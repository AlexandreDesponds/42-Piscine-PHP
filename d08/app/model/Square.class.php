<?php

    class Square extends Map implements Norm42
    {
        private $_y;
        private $_x;

        public function __construct($x, $y)
        {
            $this->_y = $y;
            $this->_x = $x;
        }

        public function getX()
        {
            return $this->_x;
        }

        public function getY()
        {
            return $this->_y;
        }

        public static function doc()
        {
            $read = fopen("Square.doc.txt", 'r');
            while ($read && !feof($read))
                echo fgets($read);
        }
    }