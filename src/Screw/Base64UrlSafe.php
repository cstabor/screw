<?php

namespace Screw;

/**
 * Base64 for URL parameters/filenames, that adhere to RFC 4648.
 * Defaults to dropping the padding on encode since it's not required for decoding, 
 * and keeps the URL free of % encodings.
 * 
 * @author user_00
 *
 */
class Base64UrlSafe {
	
	/**
	 * encode a string
	 * 
	 * @param string $data
	 * @param string $pad
	 * @return string
	 */
	public static function encode($data, $pad = null) {
		$str = str_replace(array('+', '/'), array('-', '_'), base64_encode($data));
		if (!$pad) {
			$str = rtrim($str, '=');
		}
		return $str;
	}
	
	/**
	 * decode a encode string
	 * 
	 * @param string $data
	 * @return string
	 */
	public static function decode($data) {
		return base64_decode(str_replace(array('-', '_'), array('+', '/'), $data));
	}
	
}
// end of script