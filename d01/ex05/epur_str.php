#!/usr/bin/php
<?php
    if ($argc == 2) {
        $array = array_filter(explode(' ', $argv[1]));
        $final = "";
        foreach($array as $v)
            $final .= $v." ";
        echo trim($final)."\n";
    }