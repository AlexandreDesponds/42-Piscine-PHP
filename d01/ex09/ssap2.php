#!/usr/bin/php
<?php

    function is_sort($a, $b)
    {
        $a = strtolower($a);
        $b = strtolower($b);
        $sort = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $length = strlen($a) < strlen($b) ? strlen($a) : strlen($b);
        for ($i = 0; $i < $length; $i++)
        {
            $aa = substr($a, $i, 1);
            $bb = substr($b, $i, 1);
            $ia = array_search($aa, $sort);
            $ib = array_search($bb, $sort);
            $ia = $ia === false ? ord($aa) + 100 : $ia ;
            $ib = $ib === false ? ord($bb) + 100 : $ib ;
            if ($ib < $ia)
                return false;
            if ($ib > $ia)
                return true;
        }
        return strlen($a) <= strlen($b) ? true : false;
    }

    function is_not_null($val){
        if ($val === "0")
            return true;
        return !($val === null || empty($val));
    }

    $array = array();
    unset($argv[0]);
    foreach($argv as $v){
        $tmp = array_filter(explode(" ", $v), 'is_not_null');
        foreach ($tmp as $v2)
            $array[] = $v2;
    }
    for ($i = 0; $i < count($array) - 1;)
    {
        if (is_sort($array[$i], $array[$i + 1])) {
            $i++;
        } else {
            $temp = $array[$i];
            $array[$i] = $array[$i + 1];
            $array[$i + 1] = $temp;
            $i = 0;
        }
    }

    foreach ($array as $v)
        echo $v."\n";
