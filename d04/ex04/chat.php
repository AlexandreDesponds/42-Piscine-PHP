<?php
    session_start();
    if (!($_SESSION['loggued_on_user']))
        echo "ERROR\n";
    else {
        if (file_exists('../private') && file_exists('../private/chat')) {
            $chat = unserialize(file_get_contents('../private/chat'));
            foreach ($chat as $v) {
                echo "[" . date('H:i', $v['time']) . "] <b>" . $v['login'] . "</b>: " . $v['msg'] . "<br />";
            }
        }
    }