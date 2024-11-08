<?php
namespace App\Http\Controllers;

use App\Models\DataPemilih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid as Uuid;
use Smalot\PdfParser\Parser;

class UploadFileController extends Controller
{
    public function parseDptPdf(Request $request)
    {
        DB::beginTransaction();
        $responseCode = 200;

        // Validasi file yang diunggah
        $request->validate([
            'pdf.*' => 'required|file|mimes:pdf|max:102400', // Pastikan file yang diunggah adalah PDF dan tidak melebihi 100MB
        ]);

        $filePaths = [];
        foreach ($request->file('pdf') as $file) {
            $filePaths[] = $file->store('public'); // Menyimpan setiap file dan menambahkan path ke array $filePaths
        }

        $parser = new Parser();
        $allTableData = []; // Array untuk mengumpulkan semua data dari semua file

        // Loop untuk parsing setiap file PDF
        foreach ($filePaths as $filePath) {
            $tableData = [];
            $metadata = [
                'provinsi' => '',
                'kota' => '',
                'kecamatan' => '',
                'kelurahan' => '',
                'tps' => '',
            ];

            try {
                // Parse file PDF
                $pdf = $parser->parseFile(storage_path('app/' . $filePath));
                $pages = $pdf->getPages();

                // Loop untuk setiap halaman
                foreach ($pages as $index => $page) {
                    $text = $page->getText();
                    $lines = explode("\n", $text);

                    foreach ($lines as $line) {
                        $line = trim($line);

                        // Ekstraksi metadata berdasarkan pola tertentu
                        if (preg_match('/^PROVINSI\s*:\s*(.+?)\s*:\s*(.+)$/i', $line, $matches)) {
                            $metadata['provinsi'] = trim($matches[1]);
                            $metadata['kecamatan'] = trim($matches[2]);
                        } elseif (preg_match('/^KABUPATEN\/KOTA\s*:\s*(.+?)\s*:\s*(.+)$/i', $line, $matches)) {
                            $metadata['kota'] = trim($matches[1]);
                            $metadata['kelurahan'] = trim($matches[2]);
                        } elseif (preg_match('/^\s*:\s*(.+)$/i', $line, $matches)) {
                            $metadata['tps'] = trim($matches[1]);
                        }

                        // Cek apakah baris merupakan baris tabel
                        if (preg_match('/^(\d+)\s*(.+?)\s*([LP])\s*(\d+)\s*(.+?)\s*(\d+)\s*(\d+)/', $line, $matches)) {
                            $tableData[] = [
                                "id" => Uuid::uuid7(),
                                'name' => trim($matches[2]),
                                'gender' => trim($matches[3]),
                                'age' => (int) $matches[4],
                                'address' => trim($matches[5]),
                                'rt' => trim($matches[6]),
                                'rw' => trim($matches[7]),
                                'tps' => $metadata['tps'],
                                'kelurahan_desa' => $metadata['kelurahan'],
                                'kecamatan' => $metadata['kecamatan'],
                                'kabkota' => $metadata['kota'],
                                'provinsi' => $metadata['provinsi'],
                            ];
                        }
                    }
                }

                // Commit setiap kali selesai mengurai satu file
                if (!empty($tableData)) {
                    $allTableData = array_merge($allTableData, $tableData); // Simpan data dari file ini
                    DataPemilih::insert($allTableData); // Uncomment to save to database
                    DB::commit(); // Commit untuk data dari file ini
                }

            } catch (\Exception $e) {
                DB::rollBack(); // Rollback hanya untuk file yang gagal diproses
                $responseCode = 500;
                return response()->json([
                    "message" => "Error processing file: " . $e->getMessage(),
                ], $responseCode);
            }
        }

        // Setelah semua file selesai diproses, kembalikan response
        if (empty($allTableData)) {
            return response()->json([
                "message" => "Gagal mengurai data dari PDF. Silakan periksa struktur PDF atau coba lagi.",
            ], 500);
        }

        return response()->json([
            "data" => $allTableData,
            "message" => "Berhasil Menambahkan Data",
        ], $responseCode);
    }

}
