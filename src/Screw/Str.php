<?php

namespace Screw;

class Str
{
    /**
     *  生成指定长度的随机字符串(包含大写英文字母, 小写英文字母, 数字)
     *
     * @param int $length 需要生成的字符串的长度
     * @return string 包含 大小写英文字母 和 数字 的随机字符串
     */
    public static function randomAlphabetAndDigit($length)
    {
        $charsSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return self::randomByCharsSpace($length, $charsSpace);
    }

    /**
     * @param $length
     * @param $charsSpace
     * @return string
     */
    public static function randomByCharsSpace($length, $charsSpace) {
        $result = '';
        $charsArray = str_split($charsSpace);
        for($i = 0; $i < $length; $i++){
            $item = array_rand($charsArray);
            $result .= $charsArray[$item];
        }
        return $result;
    }
}