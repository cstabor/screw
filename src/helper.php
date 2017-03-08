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
 * get random value
 * 
 * @param array $arr
 * @return string
 */
function array_random_value($arr) {
	return $arr[array_rand($arr)];
}

/**
 * support private property
 *
 * $param object $object
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

/**
 * only support public property
 */
function object_to_array($d) {
	if (is_object($d)) {
		// Gets the properties of the given object
		// with get_object_vars function
		$d = get_object_vars($d);
	}

	if (is_array($d)) {
		/*
		 * Return array converted to object
		 * Using __FUNCTION__ (Magic constant)
		 * for recursive call
		 */
		return array_map(__FUNCTION__, $d);
	} else {
		// Return array
		return $d;
	}
}

function camel_to_underscore($name) {
	$temp_array = [];
	for($i=0;$i<strlen($name);$i++){
		$ascii_code = ord($name[$i]);
		if($ascii_code >= 65 && $ascii_code <= 90){
			if($i == 0){
				$temp_array[] = chr($ascii_code + 32);
			}else{
				$temp_array[] = '_'.chr($ascii_code + 32);
			}
		}else{
			$temp_array[] = $name[$i];
		}
	}
	return implode('',$temp_array);
}

