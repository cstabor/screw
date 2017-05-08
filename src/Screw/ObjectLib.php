<?php
/**
 * Created by PhpStorm.
 * User: gavin
 * Date: 2017-3-15
 * Time: 21:52
 */

namespace Screw;


class ObjectLib
{
    public static function objectToArray($object)
    {
        $array = $object;
        if(is_object($object)) {
            $array = (array)$object;
        }

        if(is_array($array)) {
            foreach($array as $key => $value) {
//                $array[$key] = call_user_func([__CLASS__, 'objectToArray'], $value);
                $array[$key] = call_user_func([__CLASS__, __METHOD__], $value);
            }
        }
        return $array;
    }

    public static function objectToArrayMap($object)
    {
        $array = $object;
        if(is_object($object)) {
            $array = (array)$object;
//            $array = get_object_vars($object);
        }

        if(is_array($array)) {
//            return array_map([__CLASS__, __METHOD__], $array);
            return array_map([__CLASS__, 'objectToArrayMap'], $array);
        }
        return $array;
    }

    public static function objectToArrayJson($object)
    {
        return json_decode(json_encode($object), true);
    }

}