<?php

    class Render
    {
        const VERTEX = 'vertex';
        const EDGE = 'edge';
        const RASTERIZE = 'rasterize';
        static $verbose = false;
        private $_width;
        private $_height;
        private $_filename;
        private $_image;

        public function __construct($width, $height, $filename)
        {
            $this->_height = $height;
            $this->_width = $width;
            $this->_filename = $filename;
            $this->_image = imagecreate((integer)$this->_width, (integer)$this->_height);
            imagecolorallocate($this->_image, 0, 0, 0);
            if (Self::$verbose)
                echo "Render instance constructed\n";
        }

        public function renderVertex(Vertex $screenVertex)
        {
            $color = imagecolorallocate($this->_image, $screenVertex->getColor()->red, $screenVertex->getColor()->green, $screenVertex->getColor()->blue);
            imagesetpixel($this->_image, $screenVertex->getX() + $this->_width / 2, $screenVertex->getY() + $this->_height / 2, $color);
        }

        public function renderEdge(Vertex $a, Vertex $b)
        {
            $color1 = imagecolorallocate($this->_image, $a->getColor()->red, $b->getColor()->green, $b->getColor()->blue);
            $color2 = imagecolorallocate($this->_image, $b->getColor()->red, $b->getColor()->green, $b->getColor()->blue);
            imagesetstyle($this->_image, array($color1, $color2));
            imageline($this->_image, $a->getX() + $this->_width / 2, $a->getY() + $this->_height / 2, $b->getX() + $this->_width / 2, $b->getY() + $this->_height / 2, IMG_COLOR_STYLED);
        }

        public function renderTriangle(Triangle $triangle, $mode)
        {
            $this->renderVertex($triangle->getA()->opposite());
            $this->renderVertex($triangle->getB()->opposite());
            $this->renderVertex($triangle->getC()->opposite());
        }

        public function renderMesh($mesh, $mode)
        {
            if ($mode == Self::EDGE) {
                foreach ($mesh as $k => $triangle) {
                    $this->renderEdge($triangle[0], $triangle[1]);
                    $this->renderEdge($triangle[1], $triangle[2]);
                    $this->renderEdge($triangle[2], $triangle[0]);
                }
            } else {
                foreach ($mesh as $k => $triangle) {
                    $this->renderVertex($triangle[0]);
                    $this->renderVertex($triangle[1]);
                    $this->renderVertex($triangle[2]);
                }
            }
        }

        public function develop()
        {
            imagepng($this->_image, $this->_filename);
            imagedestroy($this->_image);
        }

        function __destruct()
        {
            if (Self::$verbose)
                echo "Render instance destructed\n";
        }

        function __toString()
        {
            return ("Je suis le render\n");
        }

        public static function doc()
        {
            $read = fopen("Render.doc.txt", 'r');
            echo "\n";
            while ($read && !feof($read))
                echo fgets($read);
            echo "\n";
        }
    }