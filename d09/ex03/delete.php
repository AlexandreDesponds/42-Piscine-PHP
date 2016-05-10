<?php
    $list = '';
    $max = 0;
    if (file_exists("list.csv") && isset($_GET["id"]) && !empty($_GET["id"]))
    {
        $file = file("list.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($file as $line) {
            $tmp = explode(";", $line);
            if ($tmp[0] != $_GET['id'])
                $list .= $tmp[0].";".$tmp[1].PHP_EOL;
        }
        file_put_contents("list.csv", $list);
    }