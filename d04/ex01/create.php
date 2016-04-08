<?php
    if ($_POST['login'] && $_POST['passwd'] && $_POST['submit'] && $_POST['submit'] === "OK") {
        if (!file_exists('../private')) {
            mkdir("../private");
        }
        if (!file_exists('../private/passwd')) {
            file_put_contents('../private/passwd', null);
        }
        $account = unserialize(file_get_contents('../private/passwd'));
        if ($account) {
            $exist = 0;
            foreach ($account as $k => $v) {
                if ($v['login'] === $_POST['login'])
                    $exist = 1;
            }
        }
        if ($exist) {
            echo "ERROR\n";
        } else {
            $tmp['login'] = $_POST['login'];
            $tmp['passwd'] = hash('whirlpool', $_POST['passwd']);
            $account[] = $tmp;
            file_put_contents('../private/passwd', serialize($account));
            echo "OK\n";
        }
    } else {
        echo "ERROR\n";
    }
?>