<?php

    class Dice implements Norm42
    {
        private static $_min = 1;
        private static $_max = 6;
        private static $instance = null;

        private function __construct()
        {

        }

        private function rand()
        {
            return mt_rand(self::$_min, self::$_max);
        }

        public static function cast()
        {
            if (is_null(self::$instance)) {
                self::$instance = new Dice();
            }
            return self::$instance->rand();
        }

        public static function doc()
        {
            $read = fopen("Dice.doc.txt", 'r');
            while ($read && !feof($read))
                echo fgets($read);
        }
    }