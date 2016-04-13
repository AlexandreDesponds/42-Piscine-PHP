<?php

    require_once 'Color.class.php';

    class Vertex
    {
        private $_x;
        private $_y;
        private $_z;
        private $_w = 1;
        private $_color;
        static $verbose = false;

        public function __construct($xyzc)
        {
            $this->_x = $xyzc['x'];
            $this->_y = $xyzc['y'];
            $this->_z = $xyzc['z'];
            if (isset($xyzc['w']) && !empty($xyzc['w']))
                $this->_w = $xyzc['w'];
            if (isset($xyzc['color']) && !empty($xyzc['color']) && $xyzc['color'] instanceof Color) {
                $this->_color = $xyzc['color'];
            } else {
                $this->_color = new Color(array('red' => 255, 'green' => 255, 'blue' => 255));
            }
            if (Self::$verbose)
                printf("Vertex( x: %0.2f, y: %0.2f, z:%0.2f, w:%0.2f, Color( red: %3d, green: %3d, blue: %3d ) ) constructed\n", $this->_x, $this->_y, $this->_z, $this->_w, $this->_color->red, $this->_color->green, $this->_color->blue);
        }

        function __destruct()
        {
            if (Self::$verbose)
                printf("Vertex( x: %0.2f, y: %0.2f, z:%0.2f, w:%0.2f, Color( red: %3d, green: %3d, blue: %3d ) ) destructed\n", $this->_x, $this->_y, $this->_z, $this->_w, $this->_color->red, $this->_color->green, $this->_color->blue);
        }

        function __toString()
        {
            if (Self::$verbose)
                return (vsprintf("Vertex( x: %0.2f, y: %0.2f, z:%0.2f, w:%0.2f, Color( red: %3d, green: %3d, blue: %3d ) )", array($this->_x, $this->_y, $this->_z, $this->_w, $this->_color->red, $this->_color->green, $this->_color->blue)));
            return (vsprintf("Vertex( x: %0.2f, y: %0.2f, z:%0.2f, w:%0.2f )", array($this->_x, $this->_y, $this->_z, $this->_w)));
        }

        public static function doc()
        {
            $read = fopen("Vertex.doc.txt", 'r');
            echo "\n";
            while ($read && !feof($read))
                echo fgets($read);
            echo "\n";
        }

        public function getX()
        {
            return $this->_x;
        }

        public function setX($x)
        {
            $this->_x = $x;
        }

        public function getY()
        {
            return $this->_y;
        }

        public function setY($y)
        {
            $this->_y = $y;
        }

        public function getZ()
        {
            return $this->_z;
        }

        public function setZ($z)
        {
            $this->_z = $z;
        }

        public function getW()
        {
            return $this->_w;
        }

        public function setW($w)
        {
            $this->_w = $w;
        }

        public function getColor()
        {
            return $this->_color;
        }

        public function setColor($color)
        {
            $this->_color = $color;
        }
           }