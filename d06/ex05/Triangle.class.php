<?php

    class Triangle
    {
        static $verbose = false;
        private $_a;
        private $_b;
        private $_c;

        public function __construct($a, $b, $c)
        {
            if ($a instanceof Vertex && $b instanceof Vertex && $c instanceof Vertex) {
                $this->_a = $a;
                $this->_b = $b;
                $this->_c = $c;
            } else {
                $this->__destruct();
            }
        }

        function __destruct()
        {
            if (Self::$verbose)
                echo "delete triangle\n";
        }

        function __toString()
        {
            if (Self::$verbose)
                return (vsprintf("Vertex( x: %0.2f, y: %0.2f, z:%0.2f, w:%0.2f, Color( red: %3d, green: %3d, blue: %3d ) )", array($this->_x, $this->_y, $this->_z, $this->_w, $this->_color->red, $this->_color->green, $this->_color->blue)));
            return (vsprintf("Vertex( x: %0.2f, y: %0.2f, z:%0.2f, w:%0.2f )", array($this->_x, $this->_y, $this->_z, $this->_w)));
        }

        public static function doc()
        {
            $read = fopen("Triangle.doc.txt", 'r');
            echo "\n";
            while ($read && !feof($read))
                echo fgets($read);
            echo "\n";
        }

        public function getA()
        {
            return $this->_a;
        }

        public function getB()
        {
            return $this->_b;
        }

        public function getC()
        {
            return $this->_c;
        }


    }