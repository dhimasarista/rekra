<?php
namespace App\Http\Controllers;

use App\Models\DataPemilih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid as Uuid;
use Smalot\PdfParser\Config;
use Smalot\PdfParser\Parser;

class UploadFileController extends Controller
{
    public function parseDptPdf(Request $request)
    {
        DB::beginTransaction();
        $responseCode = 200;

        // Validasi file yang diunggah
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:4096', // Pastikan file yang diunggah adalah PDF dan tidak melebihi 4MB
        ]);

        // Simpan file yang diunggah ke penyimpanan
        $filePath = $request->file('pdf')->store('public');

        // Buat objek parser untuk membaca file PDF
        $config = new Config();
        $config->setDecodeMemoryLimit(1000000000);
        $parser = new Parser([], $config);

        // Parse file PDF
        $pdf = $parser->parseFile(storage_path('app/' . $filePath));

        // Inisialisasi penyimpanan metadata dan data tabel
        $tableData = [];
        $metadata = [
            'provinsi' => '',
            'kota' => '',
            'kecamatan' => '',
            'kelurahan' => '',
            'tps' => '',
        ];

        // Ambil semua halaman dan akumulasikan data
        $pages = $pdf->getPages();
        foreach ($pages as $index => $page) {
            try {
                $text = $page->getText(); // Ambil teks dari halaman

                // Pisahkan teks menjadi baris-baris
                $lines = explode("\n", $text);

                foreach ($lines as $line) {
                    $line = trim($line); // Hilangkan spasi di awal dan akhir baris

                    // Ekstraksi metadata berdasarkan pola tertentu
                    if (preg_match('/^PROVINSI\s*:\s*(.+?)\s*:\s*(.+)$/i', $line, $matches)) {
                        $metadata['provinsi'] = trim($matches[1]); // Ambil nama provinsi
                        $metadata['kecamatan'] = trim($matches[2]); // Ambil nama kecamatan
                    } elseif (preg_match('/^KABUPATEN\/KOTA\s*:\s*(.+?)\s*:\s*(.+)$/i', $line, $matches)) {
                        $metadata['kota'] = trim($matches[1]); // Ambil nama kota
                        $metadata['kelurahan'] = trim($matches[2]); // Ambil nama kelurahan
                    } elseif (preg_match('/^\s*:\s*(.+)$/i', $line, $matches)) {
                        // Tangkap nilai setelah titik dua sebagai TPS
                        $metadata['tps'] = trim($matches[1]);
                    }

                    // Cek apakah baris merupakan baris tabel
                    if (preg_match('/^(\d+)\s+(.+?)\s+([LP])\s+(\d+)\s+(.+?)\s+(\d+)\s+(\d+)/', $line, $matches)) {
                        // Simpan data tabel ke dalam array
                        $tableData[] = [
                            // 'no' => trim($matches[1]),
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
            } catch (\Exception $e) {
                DB::rollBack();
                // Jika terjadi kesalahan, kembalikan kode respon 500
                $responseCode = 500;
                return response()->json([
                    "message" => "Error processing page {$index}: " . $e->getMessage(), // Kembalikan pesan kesalahan
                ], $responseCode);
            }
        }

        // Cek apakah array data tabel kosong, yang menunjukkan kemungkinan masalah dengan parsing PDF
        if (empty($tableData)) {
            $responseCode = 500;
            DB::rollBack();
            return response()->json([
                "message" => "Gagal mengurai data dari PDF. Silakan periksa struktur PDF atau coba lagi.",
            ], $responseCode);
        } else {
            DataPemilih::insert($tableData);
            DB::commit();
        }
        // Kembalikan respon JSON dengan data tabel dan metadata
        return response()->json([
            "data" => $tableData,
            "metadata" => $metadata,
        ], $responseCode);
    }
}
