<?php

namespace app\helpers;


class StrHelper
{
    public static function translit($str)
    {
        $translit_table = [
            'а' => 'a',     'б' => 'b',   'в' => 'v',   'г' => 'g',   'д' => 'd',
            'е' => 'e',     'ё' => 'e',   'ж' => 'zh',  'з' => 'z',   'и' => 'i',
            'к' => 'k',     'л' => 'l',   'м' => 'm',   'н' => 'n',   'о' => 'o',
            'п' => 'p',     'р' => 'r',   'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',     'х' => 'h',   'ц' => 'c',   'ч' => 'ch',  'ш' => 'sh',
            'щ' => 'shch',  'ы' => 'y',   'э' => 'e',   'ю' => 'u',   'я' => 'ya'
        ];

        $slug = mb_strtolower($str);
        $slug = preg_replace('/[^\p{L}0-9\-_ ]/u', '', $slug);
        $slug = preg_replace('/[ьъ]+/u', '', $slug);
        $slug = preg_replace('/[й]+/u', 'y', $slug);

        $slug = strtr($slug, $translit_table);

        $slug = preg_replace('/\s+/u', '_', $slug);
        $slug = preg_replace('/[^\w\-]+/u', '', $slug);
        $slug = preg_replace('/\-\-+/u', '-', $slug);
        $slug = preg_replace('/_i_+/u', '_', $slug);
        $slug = preg_replace('/^-+/', '', $slug);
        $slug = preg_replace('/-+$/', '', $slug);

        return $slug;
    }


    public static function truncateString($str, $max)
    {
        $max = $max - 3;  // резервируем место под три точки

        if (mb_strlen($str, 'utf-8') > $max) {
            $sub_str = mb_substr($str, 0, $max, 'utf-8');
            $result_str = trim($sub_str) . "...";
        } else {
            $result_str = $str;
        }

        return $result_str;
    }


    // возвращает TRUE, если подстрока $needle входит в строку $haystack, в противном случае возвращает FALSE
    public static function inStr($needle, $haystack)
    {
        return strpos($haystack, $needle) !== false;
    }


    public static function phone($phone)
    {
        if ($phone) {
            return '+7 (' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . ' ' . substr($phone, 6, 2) . ' ' . substr($phone, 8, 2);
        }
        return '';
    }


    public static function itemsList($items_str)
    {
        $items_list = '';

        if ($items_str) {

            $atems_arr = explode(',', $items_str);

            foreach ($atems_arr as $key => $item) {

                $items_list .= '<div style="margin-bottom: 5px">' . $item . ($key < (count($atems_arr) - 1) ? ', ' : '') . '</div>';
            }

            return $items_list;
        }
        return '';
    }


    /**
     * Выбирает слово с правильными окончанием после числительного.
     *
     * @param int $number число
     * @param array $words варианты склонений ['яблоко', 'яблока', 'яблок']
     * @return string
     */
    // public static function pluralDeclension($number, array $words)
    // {
    //     return $words[($number % 100 > 4 && $number % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][min($number % 10, 5)]];
    // }
}