<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class UploadFileController extends Controller
{
    public function parseDptPdf(Request $request)
    {
        // Validasi file yang di-upload
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Simpan file yang di-upload ke storage
        $filePath = $request->file('pdf')->store('public');

        // Parse PDF
        $parser = new Parser();
        $pdf = $parser->parseFile(storage_path('app/' . $filePath));

        // Extract text from each page
        $pages = $pdf->getPages();
        $tableData = [];
        $metadata = [
            'provinsi' => '',
            'kota' => '',
            'kecamatan' => '',
            'kelurahan' => '',
            'tps' => '',
        ];

        foreach ($pages as $page) {
            $text = $page->getText();

            // Split text into lines
            $lines = explode("\n", $text);

            foreach ($lines as $line) {
                $line = trim($line);

                // Extract metadata
                if (strpos($line, 'PROVINSI') === 0) {
                    $metadata['provinsi'] = trim(explode(':', $line)[1]);
                } elseif (strpos($line, 'KABUPATEN/KOTA') === 0) {
                    $metadata['kota'] = trim(explode(':', $line)[1]);
                } elseif (strpos($line, 'KECAMATAN') === 0) {
                    $metadata['kecamatan'] = trim(explode(':', $line)[1]);
                } elseif (strpos($line, 'DESA/KELURAHAN') === 0) {
                    $metadata['kelurahan'] = trim(explode(':', $line)[1]);
                } elseif (strpos($line, 'TPS') === 0) {
                    $metadata['tps'] = trim(explode(':', $line)[1]);
                }

                // Detect and parse table header
                if (preg_match('/NO\s+NAMA\s+JENIS\s+KELAMIN\s+USIA/', $line)) {
                    continue; // Skip header row
                }

                // Parse table rows
                $columns = preg_split('/\s{2,}/', $line);
                if (count($columns) >= 8) {
                    list($no, $nama, $jenis_kelamin, $usia, $alamat, $rt, $rw, $ket) = $columns;

                    $tableData[] = [
                        'nama' => $nama,
                        'jenis_kelamin' => $jenis_kelamin,
                        'usia' => (int) $usia,
                        'alamat' => $alamat,
                        'rt' => $rt,
                        'rw' => $rw,
                        'tps' => $metadata['tps'],
                        'kelurahan' => $metadata['kelurahan'],
                        'kecamatan' => $metadata['kecamatan'],
                        'kota' => $metadata['kota'],
                        'provinsi' => $metadata['provinsi'],
                    ];
                }

                // Stop parsing if footer or summary is detected
                if (preg_match('/Rekapitulasi Pemilih Per TPS/', $line)) {
                    break 2; // Exit both foreach loops
                }
            }
        }

        // Return the JSON response
        return response()->json($tableData);
    }
}
