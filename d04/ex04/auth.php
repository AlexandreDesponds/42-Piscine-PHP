<?php
    function auth($login, $passwd) {
        if (!file_exists('../private')) {
            mkdir("../private");
        }
        if (!file_exists('../private/passwd')) {
            file_put_contents('../private/passwd', null);
        }
        $account = unserialize(file_get_contents('../private/passwd'));
        if ($account) {
            foreach ($account as $k => $v) {
                if ($v['login'] === $login && $v['passwd'] === hash('whirlpool', $passwd))
                    return true;
            }
        }
        return false;
    }