<?php

use App\Models\Language;
use Illuminate\Support\Str;
use Ramsey\Uuid\Type\Integer;

/** Format News Tags */
function formatTags(array $tags): String
{
    // dd($tags);
    return implode(',', $tags);
}

/** get selected language from session */
function getLanguage(): string
{
    if (session()->has('language')) {
        return session('language');
    } else {
        try {
            $language = Language::where('default', 1)->first();
            setLanguage($language->lang);
            return $language->lang;
        } catch (\Throwable $th) {
            setLanguage('en');
            return 'en';
        }
    }
}


/** set language from session */
function setLanguage(string $code): void
{
    session(['language' => $code]);
}


/** truncate text */
function truncate(string $text, int $limit = 50): String
{
    return Str::limit($text, $limit, '...');
}

/** truncate html tag */
function truncateHtml(string $text, int $limit = 50): String
{
    return Str::limit(strip_tags($text), $limit, '...');
}

/** convert a number in K format */
function convertToKFormat(int $number): String
{
    if ($number < 1000) {
        return $number;
    } elseif ($number < 1000000) {
        return round($number / 1000, 1) . 'K';
    } else {
        return round($number / 1000000, 1) . 'M';
    }
}
