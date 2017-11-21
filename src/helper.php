<?php

/**
 * print a mixed value to screen or return
 *
 * @param mixed $var
 * @param boolean $return
 * @return string
 */
function println($var, $return = false)
{
    if (is_null($var)) {
        $val = sprintf("(NULL)");
    } elseif (is_scalar($var)) {
        if (is_bool($var)) {
            if ($var) {
                $val = sprintf("bool(true)");
            } else {
                $val = sprintf("bool(false)");
            }
        } elseif (is_float($var)) {
            $val = sprintf("%f", $var);
        } elseif (is_integer($var)) {
            $val = sprintf("%d", $var);
        } elseif (is_string($var)) {
            $val = sprintf("\"%s\"", $var);
        } else {
            $val = sprintf("untreated data: \"%s\"", $var);
        }
    } else {
        $val = print_r($var, true);
    }
    
    $val = trim($val);
    if (PHP_SAPI === 'cli') {
        $val .= PHP_EOL;
    } else {
        $val = sprintf("<pre>%s</pre>", $val);
    }
    
    if ($return) {
        return $val;
    }
    echo $val;
}

/**
 * get random
 *
 * @param $arr
 * @param int $num
 * @return string|array
 */
function array_random($arr, $num = 1)
{
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
function object_array($object)
{
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