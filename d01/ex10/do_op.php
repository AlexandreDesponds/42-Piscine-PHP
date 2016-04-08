#!/usr/bin/php
<?php
    if ($argc != 4) {
        echo "Incorrect Parameters\n";
        exit();
    }
    switch (trim($argv[2], " \t")) {
        case ("*") :
            echo trim($argv[1], " \t") * trim($argv[3], " \t");
            break;
        case ("+") :
            echo trim($argv[1], " \t") + trim($argv[3], " \t");
            break;
        case ("-") :
            echo trim($argv[1], " \t") - trim($argv[3], " \t");
            break;
        case ("/") :
            echo trim($argv[1], " \t") / trim($argv[3], " \t");
            break;
        case ("%") :
            echo trim($argv[1], " \t") % trim($argv[3], " \t");
            break;
    }
    echo "\n";