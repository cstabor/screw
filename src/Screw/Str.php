<?php

namespace Screw;

class Str
{
    
    const DIGIT = '0123456789';
    
    const ALPHABET = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
    const SPECIAL_CHARS = '|@#~$%()=^*+[]{}-_';
    
    /**
     * 生成指定长度的随机字符串(包含大写英文字母, 小写英文字母, 数字)
     *
     * @param int $length 需要生成的字符串的长度
     * @return string 包含 大小写英文字母 和 数字 的随机字符串
     */
    public static function randomAlphabetAndDigit($length)
    {
        $charsSpace = self::DIGIT.self::ALPHABET;
        return self::randomByCharsSpace($length, $charsSpace);
    }
    
    /**
     * 减少循环次数，使用php原生函数，效率要比循环生成高
     *
     * @param $length
     * @return bool|string
     */
    public static function random62($length)
    {
        $str = self::DIGIT.self::ALPHABET;
        
        $strLength = 62;
        while($length > $strLength){
            $str .= $str;
            $strLength += 60;
        }
        
        $str = str_shuffle($str);
        return substr($str, 0,$length);
    }
    
    /**
     * @param int $length
     * @param string $charsSpace
     * @return string
     */
    public static function randomByCharsSpace($length, $charsSpace)
    {
/*        $result = '';
        $charsArray = str_split($charsSpace);
        for ($i = 0; $i < $length; $i++) {
            $item = array_rand($charsArray);
            $result .= $charsArray[$item];
        }
        return $result;*/
        $result = '';
        $spaceLength = strlen($charsSpace);
        for ($i = 0; $i < $length; $i++) {
            $result .= $charsSpace[rand(0, $spaceLength-1)];
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
    
    /**
     * 把字符按全角截短
     *
     * 不过滤html特殊符号,"\r"将被丢弃
     *
     * @param string $src
     * @param int $len 全角字符数量,英文数字算半个
     * @return string
     */
    public static function gbkTruncate($src, $len) {
        $src = strval($src);
        $dest = '';
        $dest_len = 0;
        $src_len = strlen($src);
        for ($i=0;$i<$src_len && $dest_len < $len ; $i++) {
            $ascii = ord($src[$i]);
            
            //单字节部分
            if($ascii < 0x7F)		{
                //控制字符特殊处理
                if(ctype_cntrl($src[$i]) )	{
                    //保留制表符跟回车符
                    if($ascii==0x09 || $ascii==0x0A) {
                        $dest .= $src[$i];
                        $dest_len += 0.5;
                    }
                    //丢掉其它控制字符
                }
                //其它的补充上
                else			{
                    $dest .= $src[$i];
                    $dest_len += 0.5;
                }
            }
            //多字节部分,合法的第一个
            elseif ($ascii >= 0x81 && $ascii<=0xFE)		{
                //丢掉最后半个汉字
                if (1 == ($src_len-$i))			{
                    break;
                }
                //检查第二个字节
                //0x40 - 0xFE
                $b2 = ord($src[++$i]);
                if($b2 >= 0x40 && $b2 <= 0xFE)			{
                    //最后半个
                    if ($dest_len+.5==$len) {
                        break;
                    }
                    $dest .= $src[$i-1] . $src[$i];
                    $dest_len += 1 ;
                }
                //不是gbk范围去掉
            }
            //不是gbk范围去掉
        }
        return $dest;
    }
    
}