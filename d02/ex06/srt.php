#!/usr/bin/php
<?php

    function ft_is_time($a) {
        return preg_match("/^[0-9][0-9]:[0-9][0-9]:[0-9][0-9],[0-9][0-9][0-9] --> [0-9][0-9]:[0-9][0-9]:[0-9][0-9],[0-9][0-9][0-9]$/", $a);
    }

    function is_sort($a, $b) {
        return strcmp($a, $b);
    }

    function swap($time, $a, $b) {
        $tmp = $time[$a];
        $time[$a] = $time[$b];
        $time[$b] = $tmp;
    }

    if ($argc != 2 || !file_exists($argv[1]))
        exit();

    $read = fopen($argv[1], 'r');
    while ($read && !feof($read))
        $array[] = fgets($read);

    foreach($array as $k => $v){
        if (ft_is_time($v)) {
            $time[$k] = $v;
        }
    }

    sort($time);

    $index = 0;

    foreach($array as $k => $v){
        if (ft_is_time($v)) {
            echo $time[$index];
            $index++;
        } else {
            echo $v;
        }
    }