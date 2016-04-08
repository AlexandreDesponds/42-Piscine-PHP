#!/usr/bin/php
<?php
    if ($argc != 2)
        exit();

    $line = array();
    $user = array();
    $stdin = fopen('php://stdin', 'r');
    fgets($stdin);
    while ($stdin && !feof($stdin)) {
        $tmp = explode(";", fgets($stdin));
        if (count($tmp) == 4) {
            $line[] = $tmp;
            if (!array_key_exists($tmp[0], $user)) {
                $user[$tmp[0]] = null;
                $user[$tmp[0]]['total'] = 0;
                $user[$tmp[0]]['count'] = 0;
                $user[$tmp[0]]['moulinette'] = 0;
            }
        }
    }

    ksort($user);

    if ($argv[1] === "moyenne") {
        $total = 0;
        $count = 0;
        foreach ($line as $v) {
            if ($v[2] !== "moulinette" && $v[1] !== '') {
                $count++;
                $total += $v[1];
            }
        }
        echo ($total / $count) . "\n";
    } else if ($argv[1] === "moyenne_user" || $argv[1] === "ecart_moulinette") {
        foreach ($line as $v) {
            if ($v[1] !== '' && $v[2] !== "moulinette") {
                $user[$v[0]]['count'] += 1;
                $user[$v[0]]['total'] += $v[1];
            } else if ($v[2] === "moulinette"){
                $user[$v[0]]['moulinette'] = $v[1];
            }
        }

        if ($argv[1] === "moyenne_user") {
            foreach ($user as $k => $v) {
                echo $k . ":" . ($v['total'] / $v['count']) . "\n";
            }
        } else {
            foreach ($user as $k => $v) {
                echo $k . ":" . (($v['total'] / $v['count']) - $v['moulinette']) . "\n";
            }
        }
    }