<?php

namespace App\Helper;

class SlugHelper
{
    public static function makeSlug(string $string): string
    {
        mb_internal_encoding("UTF-8");
        $string = mb_strtolower($string);
        $string = htmlspecialchars_decode($string);
        $string = preg_replace('/(\s)/', ' ', $string);
        $string = trim($string);
        $trans  = [
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'yo',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'shch',
            'ь' => '',
            'ы' => 'i',
            'ъ' => '',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            ':' => '-',
            '&' => '-',
            '(' => '-',
            ')' => '-',
            ',' => '-',
            ' ' => '-',
            '_' => '-',
            '?' => '',
            '«' => '',
            '»' => '',
        ];
    
        $string = strtr($string, $trans);
        $string = preg_replace('/[\x00-\x2C\x7B-\xFF]/', '-', $string);
        $string = preg_replace('#-{2,}#', '-', $string);
        
        return trim($string, ' -');
    }
    
}