<?php

    class Color
    {
        public $red;
        public $green;
        public $blue;
        static $verbose = false;

        public function __construct($color)
        {
            if (isset($color['red']) && isset($color['green']) && isset($color['blue'])) {
                $this->red = intval($color['red']);
                $this->green = intval($color['green']);
                $this->blue = intval($color['blue']);
            } else if (isset($color['rgb'])) {
                $rgb = intval($color["rgb"]);
                $this->red = $rgb / 65281 % 256;
                $this->green = $rgb / 256 % 256;
                $this->blue = $rgb % 256;
            }
            if (Self::$verbose)
                printf("Color( red: %3d, green: %3d, blue: %3d ) constructed.\n", $this->red, $this->green, $this->blue);
        }

        function __destruct()
        {
            if (Self::$verbose)
                printf("Color( red: %3d, green: %3d, blue: %3d ) destructed.\n", $this->red, $this->green, $this->blue);
        }

        public function add($Color)
        {
            return (new Color(array('red' => $this->red + $Color->red, 'green' => $this->green + $Color->green, 'blue' => $this->blue + $Color->blue)));
        }

        public function sub($Color)
        {
            return (new Color(array('red' => $this->red - $Color->red, 'green' => $this->green - $Color->green, 'blue' => $this->blue - $Color->blue)));
        }

        public function mult($mult)
        {
            return (new Color(array('red' => $this->red * $mult, 'green' => $this->green * $mult, 'blue' => $this->blue * $mult)));
        }

        function __toString()
        {
            return (vsprintf("Color( red: %3d, green: %3d, blue: %3d )", array($this->red, $this->green, $this->blue)));
        }

        public static function doc()
        {
            $read = fopen("Color.doc.txt", 'r');
            echo "\n";
            while ($read && !feof($read))
                echo fgets($read);
            echo "\n";
        }

    }