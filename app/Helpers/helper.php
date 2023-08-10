<?php

use App\Models\Language;

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
