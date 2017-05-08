<?php
/**
 * Created by PhpStorm.
 * User: user_00
 * Date: 2/17/17
 * Time: 3:37 PM
 */

namespace Screw;


Class HashMap
{
    private $hashTable;
    
    /*
     * HashMap构造函数
     */
    public function __construct()
    {
        $this->hashTable = [];
    }
    
    /*
     *向HashMap中添加一个键值对
     *@param $key 插入的键
     *@param $value 插入的值
    */
    public function put($key, $value)
    {
        if (!array_key_exists($key, $this->hashTable)) {
            $this->hashTable[$key] = $value;
            return null;
        } else {
            $tempValue = $this->hashTable[$key];
            $this->hashTable[$key] = $value;
            return $tempValue;
        }
    }
    
    /*
    * 根据key获取对应的value
    * @param $key
    */
    public function get($key)
    {
        if (array_key_exists($key, $this->hashTable))
            return $this->hashTable[$key];
        else
            return null;
    }
    
    /*
     *移除HashMap中所有键值对
    */
    /*
     *删除指定key的键值对
     *@param $key 要移除键值对的key
     */
    public function remove($key)
    {
        $temp_table = array();
        if (array_key_exists($key, $this->hashTable)) {
            $tempValue = $this->hashTable[$key];
            while ($curValue = current($this->hashTable)) {
                if (!(key($this->hashTable) == $key))
                    $temp_table[key($this->hashTable)] = $curValue;
                
                next($this->hashTable);
            }
            $this->hashTable = null;
            $this->hashTable = $temp_table;
            return $tempValue;
        } else
            return null;
    }
    
    /**
     * 获取HashMap的所有键值
     * @return 返回HashMap中key的集合,以数组形式返回
     */
    public function keys()
    {
        return array_keys($this->hashTable);
    }
    
    /**
     * 获取HashMap的所有value值
     */
    public function values()
    {
        return array_values($this->hashTable);
    }
    
    /**
     * 将一个HashMap的值全部put到当前HashMap中
     * @param $map
     */
    public function putAll($map)
    {
        if (!$map->isEmpty() && $map->size() > 0) {
            $keys = $map->keys();
            foreach ($keys as $key) {
                $this->put($key, $map->get($key));
            }
        }
    }
    
    /**
     * 移除HashMap中所有元素
     */
    public function removeAll()
    {
        $this->hashTable = null;
        $this->hashTable = array();
    }
    
    /*
     *HashMap中是否包含指定的值
     *@param $value
    */
    public function containsValue($value)
    {
        while ($curValue = current($this->hashTable)) {
            if ($curValue == $value) {
                return true;
            }
            next($this->hashTable);
        }
        return false;
    }
    
    /*
     *HashMap中是否包含指定的键key
     *@param $key
    */
    public function containsKey($key)
    {
        if (array_key_exists($key, $this->hashTable)) {
            return true;
        } else {
            return false;
        }
    }
    
    /*
     *获取HashMap中元素个数
     */
    public function size()
    {
        return count($this->hashTable);
    }
    
    /*
    *判断HashMap是否为空
    */
    public function isEmpty()
    {
        return (count($this->hashTable) == 0);
    }
    
    public function toString()
    {
        print_r($this->hashTable);
    }
}