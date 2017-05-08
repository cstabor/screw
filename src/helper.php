<?php

/**
 * print a mixed value to screen or return
 * 
 * @param mixed $var
 * @param boolean $return
 * @return string
 */
function println($var, $return = false) {
	if (PHP_SAPI === 'cli' || (isset ( $_SERVER ['HTTP_USER_AGENT'] )
		&& strpos ( $_SERVER ['HTTP_USER_AGENT'], 'curl' ) !== false)) {
			if (is_scalar ( $var )) {
				$val = $var . PHP_EOL;
			} else {
				$val = print_r($var, true);
				if (!$val) {
					$val .= PHP_EOL;
				}
			}
		} else {
			$val = '<pre>'.print_r($var, true).'</pre>';
		}

	if (!$return) {
		echo $val;
	} else {
		return $val;
	}
}

/**
 * get random
 *
 * @param $arr
 * @param int $num
 * @return string|array
 */
function array_random($arr, $num = 1) {
	shuffle($arr);
	$r = [];
	for ($i = 0; $i < $num; $i++) {
		$r[] = $arr[$i];
	}
	return $num === 1 ? $r[0] : $r;
}

/**
 * support private property
 *
 * @param object $object
 * @return array
 */
function object_array($object) {
	$public = [];
	$reflection = new ReflectionClass($object);
	foreach ($reflection->getProperties() as $property) {
		$property->setAccessible(true);
		if (is_object($property->getValue($object))) {
			$public[$property->getName()] = call_user_func_array(__FUNCTION__, [$property->getValue($object)]);
		} else {
			$public[$property->getName()] = $property->getValue($object);
		}
	}
	return $public;
}