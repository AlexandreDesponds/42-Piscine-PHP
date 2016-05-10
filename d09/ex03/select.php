<?php
    if (file_exists("list.csv"))
    {
        $array = array();
        $file = file("list.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($file as $line) {
            $tmp = explode(";", $line);
            $array[$tmp[0]] = $tmp[1];
        }
        echo json_encode($array);
    }
