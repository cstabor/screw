<?php

/**
 * print a mixed value to screen or return
 * 
 * @param mixed $var
 * @param string $return
 * @return string
 */
function println($var, $return = false) {
	if (PHP_SAPI == 'cli' || (isset ( $_SERVER ['HTTP_USER_AGENT'] ) && strpos ( $_SERVER ['HTTP_USER_AGENT'], 'curl' ) !== false)) {
		if (is_scalar ( $var )) {
			$val = $var . PHP_EOL;
		} else {
			$val = print_r ( $var, true );
			if (! $val) {
				$val .= PHP_EOL;
			}
		}
	} else {
		$val = "<pre>";
		$val .= print_r ( $var, true );
		$val .= "</pre>";
	}
	
	if (! $return) {
		echo $val;
	} else {
		return $val;
	}
}

function array_random($arr, $num = 1) {
    shuffle($arr);

    $r = array();
    for ($i = 0; $i < $num; $i++) {
        $r[] = $arr[$i];
    }
    return $num == 1 ? $r[0] : $r;
}