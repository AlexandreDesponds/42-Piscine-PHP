<?php
    $array = array();
    $max = 0;
    if (file_exists("list.csv") && isset($_GET["todo"]) && !empty($_GET["todo"]))
    {
        $file = file("list.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($file as $line) {
            $tmp = explode(";", $line);
            if ($tmp[0] >= $max)
                $max = $tmp[0] + 1;
        }
        file_put_contents("list.csv", $max.";".$_GET["todo"].PHP_EOL, FILE_APPEND);
    }