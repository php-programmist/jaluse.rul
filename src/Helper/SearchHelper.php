<?php

namespace App\Helper;

class SearchHelper
{
    /**
     * @param string $search
     * @param bool   $fullWordOnly
     * @param bool   $removeSpecialCharacters
     *
     * @return string
     */
    public static function prepareFullTextSearch(
        string $search,
        bool $fullWordOnly = false,
        bool $removeSpecialCharacters = false
    ): string {
        $result = trim(preg_replace('/[+\-><()~*\"@]+/', $removeSpecialCharacters ? '' : ' ', $search));
        if (!empty($result) && !$removeSpecialCharacters) {
            $result = str_replace(' ', ' +', '+' . preg_replace('/\s\s+/', ' ', $result));
            if (!$fullWordOnly) {
                $result = "$result*";
            }
        }
        
        return $result;
    }
    
    /**
     * @param string|null $query
     *
     * @return string
     */
    public static function prepareTextSearch(?string $query): string
    {
        return trim(str_replace([',', '.'], ' ',
            str_replace(['(', ')', ',', '.', '-', '"', '\\', '\'', '/', '«', '»', ':', '?', '!'], ' ', $query ?? '')));
    }
}
