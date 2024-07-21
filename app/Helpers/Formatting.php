<?php

namespace App\Helpers;

use NumberFormatter;
use DateTime;

class Formatting {

    public static function capitalize(string $input): string {
        if (empty($input) || trim($input) === '') {
            return $input;
        }

        $words = explode(' ', trim($input));

        foreach ($words as &$word) {
            if (strlen($word) > 0) {
                $word = strtoupper($word[0]) . strtolower(substr($word, 1));
            }
        }

        return implode(' ', $words);
    }

    public static function formatRupiah(float $amount): string {
        // Using 'id_ID' locale and 'currency' style directly in the constructor
        $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, 'IDR');
    }

    public static function formatUrl(array $params): string {
        $queryString = array_map(function($key, $value) {
            return urlencode($key) . '=' . urlencode($value);
        }, array_keys($params), array_values($params));

        return '?' . implode('&', $queryString);
    }

    public static function formatDateLong(DateTime $date): string {
        return $date->format('d M Y'); // Example format: 21 Jul 2024
    }

    public static function formatDateShort(DateTime $date): string {
        return $date->format('d-m-Y'); // Example format: 21-07-2024
    }
}

// Example usage:
$queryParams = [
    'code' => '500',
    'title' => 'Internal Server Error',
    'message' => 'We will fix it as soon as possible...',
];
