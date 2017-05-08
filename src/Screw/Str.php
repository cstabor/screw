<?php

namespace Screw;

class Str
{
    /**
     * 生成指定长度的随机字符串(包含大写英文字母, 小写英文字母, 数字)
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
    public static function randomByCharsSpace($length, $charsSpace)
    {
        $result = '';
        $charsArray = str_split($charsSpace);
        for ($i = 0; $i < $length; $i++) {
            $item = array_rand($charsArray);
            $result .= $charsArray[$item];
        }
        return $result;
    }
    
    /**
     * get rand visual char string
     * @param $length
     *
     * @return string
     */
    public static function random($length) {
        $res = '';
        for ($i = 0; $i < $length; $i++) {
            $res .= chr(mt_rand(33, 126));
        }
        return $res;
    }
    
    /**
     * 特殊字符转换为全角
     *
     * @param $str
     * @return string
     */
    public static function specialCharsToSBC($str)
    {
        $arr = [
            '(' => '（',
            ')' => '）',
            '[' => '“',
            ']' => '〗',
            '"' => '＂',
            '`' => '’',
            '{' => '｛',
            '}' => '｝',
            '<' => '《',
            '>' => '》',
            '%' => '％',
            '+' => '＋',
            '-' => '——',
            ':' => '：',
            '.' => '。',
            ',' => '；',
            '?' => '？',
            '!' => '！',
            '|' => '｜',
            ' ' => '　',
            '$' => '＄',
            '@' => '＠',
            '#' => '＃',
            '^' => '＾',
            '&' => '＆',
            '*' => '＊',
            '/' => '／',
        
        ];
        return strtr($str, $arr);
    }
    
    
    /**
     * 将unicode转换成字符
     *
     * @param int $unicode
     * @return string UTF-8字符
     **/
    public static function unicode2Char($unicode)
    {
        if ($unicode < 128) return chr($unicode);
        if ($unicode < 2048) return chr(($unicode >> 6) + 192) .
            chr(($unicode & 63) + 128);
        if ($unicode < 65536) return chr(($unicode >> 12) + 224) .
            chr((($unicode >> 6) & 63) + 128) .
            chr(($unicode & 63) + 128);
        if ($unicode < 2097152) return chr(($unicode >> 18) + 240) .
            chr((($unicode >> 12) & 63) + 128) .
            chr((($unicode >> 6) & 63) + 128) .
            chr(($unicode & 63) + 128);
        return false;
    }
    
    /**
     * 将字符转换成unicode
     *
     * @param string $char 必须是UTF-8字符
     * @return int
     **/
    public static function char2Unicode($char)
    {
        switch (strlen($char)) {
            case 1 :
                return ord($char);
            case 2 :
                return (ord($char{1}) & 63) |
                    ((ord($char{0}) & 31) << 6);
            case 3 :
                return (ord($char{2}) & 63) |
                    ((ord($char{1}) & 63) << 6) |
                    ((ord($char{0}) & 15) << 12);
            case 4 :
                return (ord($char{3}) & 63) |
                    ((ord($char{2}) & 63) << 6) |
                    ((ord($char{1}) & 63) << 12) |
                    ((ord($char{0}) & 7) << 18);
            default :
                trigger_error('Character is not UTF-8!', E_USER_WARNING);
                return false;
        }
    }
    
    /**
     * 半角转全角
     *
     * @param string $str
     * @return string
     **/
    public static function dbc2Sbc($str)
    {
        return preg_replace(
        // 半角字符
            '/[x{0020}x{0020}-x{7e}]/ue',
            // 编码转换
            // 0x0020是空格，特殊处理，其他半角字符编码+0xfee0即可以转为全角
            '($unicode=char2Unicode(\'\0\')) == 0x0020 ? unicode2Char（0x3000） : (($code=$unicode+0xfee0) > 256 ? unicode2Char($code) : chr($code))'
            , $str);
    }
    
    /**
     * 全角转半角
     *
     * @param string $str
     * @return string
     **/
    public static function sbc2Dbc($str)
    {
        return preg_replace(
        // 全角字符
            '/[x{3000}x{ff01}-x{ff5f}]/ue',
            // 编码转换
            // 0x3000是空格，特殊处理，其他全角字符编码-0xfee0即可以转为半角
            '($unicode=char2Unicode(\'\0\')) == 0x3000 ? " " : (($code=$unicode-0xfee0) > 256 ? unicode2Char($code) : chr($code))'
            , $str);
    }
    
    /**
     * user_name -> UserName
     *
     * @param $underline
     * @return string
     */
    public static function underlineToCamel($underline)
    {
//        return preg_replace("/(?:^|_)([a-z])/e", "strtoupper('\\1')", $underline);
        return preg_replace_callback("/(?:^|_)([a-z])/", "strtoupper", $underline);
    }
}