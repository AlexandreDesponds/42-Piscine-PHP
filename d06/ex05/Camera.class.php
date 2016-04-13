<?php

    class Camera
    {
        static $verbose = false;
        private $_proj;
        private $_tR;
        private $_tT;
        private $_origine;
        private $_width;
        private $_height;
        private $_ratio;

        public function __construct($array)
        {
            $this->_origine = $array['origin'];
            $this->_tT = new Matrix(array('preset' => Matrix::TRANSLATION, 'vtc' => $this->_origine->opposite()));

            $this->_tR = $array['orientation'];
            $this->_tR = $this->_tR->opposite();
            $this->_tR = $this->_tR->mult($this->_tT);
            $this->_width = (float)$array['width'] / 2;
            $this->_height = (float)$array['height'] / 2;
            $this->_ratio = $this->_width / $this->_height;
            $this->_proj = new Matrix(array(
                'preset' => Matrix::PROJECTION,
                'fov' => $array['fov'],
                'ratio' => $this->_ratio,
                'near' => $array['near'],
                'far' => $array['far']
            ));
            if (Self::$verbose) {
                echo "Camera instance constructed\n";
            }
        }

        public function watchVertex(Vertex $worldVertex){
            $vtx = $this->_proj->transformVertex($this->_tR->transformVertex($worldVertex));
            $vtx->setX($vtx->getX() * $this->_ratio);
            $vtx->setY($vtx->getY());
            $vtx->setColor($worldVertex->getColor());
            return ($vtx);
        }

        public function watchMesh($mesh){
            foreach($mesh as $k => $triangle) {
                $a = $this->watchVertex($triangle[0]);
                $b = $this->watchVertex($triangle[1]);
                $c = $this->watchVertex($triangle[2]);
                $mesh[$k] = array($a, $b, $c);
            }
            return $mesh;
        }

        private function _transpose(Matrix $m){
            $tmp[0] = $m->matrix[0];
            $tmp[1] = $m->matrix[4];
            $tmp[2] = $m->matrix[8];
            $tmp[3] = $m->matrix[12];
            $tmp[4] = $m->matrix[1];
            $tmp[5] = $m->matrix[5];
            $tmp[6] = $m->matrix[9];
            $tmp[7] = $m->matrix[13];
            $tmp[8] = $m->matrix[2];
            $tmp[9] = $m->matrix[6];
            $tmp[10] = $m->matrix[10];
            $tmp[11] = $m->matrix[14];
            $tmp[12] = $m->matrix[3];
            $tmp[13] = $m->matrix[7];
            $tmp[14] = $m->matrix[11];
            $tmp[15] = $m->matrix[15];
            $m->matrix = $tmp;
            return ($m);
        }

        function __destruct()
        {
            if (Self::$verbose)
                printf("Camera instance destructed\n");
        }

        function __toString()
        {
            $tmp = "Camera( \n";
            $tmp .= "+ Origine: ".$this->_origine."\n";
            $tmp .= "+ tT:\n".$this->_tT."\n";
            $tmp .= "+ tR:\n".$this->_tR."\n";
            $tmp .= "+ tR->mult( tT ):\n".$this->_tR->mult($this->_tT)."\n";
            $tmp .= "+ Proj:\n".$this->_proj."\n)";
            return ($tmp);
        }

        public static function doc()
        {
            $read = fopen("Camera.doc.txt", 'r');
            echo "\n";
            while ($read && !feof($read))
                echo fgets($read);
            echo "\n";
        }
    }