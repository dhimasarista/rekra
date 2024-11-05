<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

class UploadFileController extends Controller
{
    public function parseDptPdf(Request $request)
    {
        $responseCode = 200;

        // Validate the uploaded file
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Save the uploaded file to storage
        $filePath = $request->file('pdf')->store('public');

        // Parse the PDF file
        $parser = new Parser();
        $pdf = $parser->parseFile(storage_path('app/' . $filePath));

        // Initialize metadata and data storage
        $tableData = [];
        $metadata = [
            'provinsi' => '',
            'kota' => '',
            'kecamatan' => '',
            'kelurahan' => '',
            'tps' => '',
        ];

        // Extract text from each page and accumulate data
        $pages = $pdf->getPages();
        Log::info('Total pages in PDF: ' . count($pages));

        foreach ($pages as $index => $page) {
            try {
                $text = $page->getText();
                Log::info('Processing page ' . ($index + 1));

                // Split text into lines
                $lines = explode("\n", $text);

                foreach ($lines as $line) {
                    $line = trim($line);

                    // Improved metadata extraction
                    if (preg_match('/^PROVINSI\s*:\s*(.+)$/i', $line, $matches)) {
                        $metadata['provinsi'] = trim($matches[1]);
                    } elseif (preg_match('/^KABUPATEN\/KOTA\s*:\s*(.+)$/i', $line, $matches)) {
                        $metadata['kota'] = trim($matches[1]);
                    } elseif (preg_match('/^KECAMATAN\s*:\s*(.+)$/i', $line, $matches)) {
                        $metadata['kecamatan'] = trim($matches[1]);
                    } elseif (preg_match('/^DESA\/KELURAHAN\s*:\s*(.+)$/i', $line, $matches)) {
                        $metadata['kelurahan'] = trim($matches[1]);
                    } elseif (preg_match('/^TPS\s*:\s*(.+)$/i', $line, $matches)) {
                        $metadata['tps'] = trim($matches[1]);
                    }

                    // Detect and parse table rows
                    if (preg_match('/^(\d+)\s+([A-Za-z\s]+)\s+([LP])\s+(\d+)\s+(.+?)\s+(\d{3})\s+(\d{3})/', $line, $matches)) {
                        $tableData[] = [
                            'no' => trim($matches[1]),
                            'nama' => trim($matches[2]),
                            'jenis_kelamin' => trim($matches[3]),
                            'usia' => (int) $matches[4],
                            'alamat' => trim($matches[5]),
                            'rt' => trim($matches[6]),
                            'rw' => trim($matches[7]),
                            'tps' => $metadata['tps'],
                            'kelurahan' => $metadata['kelurahan'],
                            'kecamatan' => $metadata['kecamatan'],
                            'kota' => $metadata['kota'],
                            'provinsi' => $metadata['provinsi'],
                        ];
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error processing page ' . ($index + 1) . ': ' . $e->getMessage());
            }
        }

        // Check if table data array is empty, indicating potential issues with PDF parsing
        if (empty($tableData)) {
            $responseCode = 500;
            return response()->json([
                "error" => "Failed to parse data from PDF. Please check the PDF structure or try again.",
                "metadata" => $metadata,
            ], $responseCode);
        }

        // Return the JSON response with table data and metadata
        return response()->json([
            "data" => $tableData,
            "metadata" => $metadata,
            "pages" => $pages,
        ], $responseCode);
    }
}
