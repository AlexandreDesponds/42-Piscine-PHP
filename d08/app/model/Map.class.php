<?php

    class Map implements Norm42
    {
        const WIDTH = 150;
        const HEIGHT = 100;
        const TABLE = 'maps';

        private $_map = array();
        private static $_ratioObstacle = 700;
        private static $_sizeMacObstacle = 10;
        private static $_sizeSafeZone = 40;

        public function __construct()
        {
            for ($i = 0; $i < self::HEIGHT; $i++) {
                for ($y = 0; $y < self::WIDTH; $y++) {
                    $this->_map[$i][$y]['object'] = new Square($y, $i);
                    $this->_map[$i][$y]['type'] = 0;
                }
            }
            $this->addObstacle();
        }

        public function initMap()
        {
            Mysql::getInstance()->query("TRUNCATE TABLE " . Map::TABLE);
            for ($i = 0; $i < self::HEIGHT; $i++) {
                for ($y = Map::$_sizeSafeZone; $y < self::WIDTH - Map::$_sizeSafeZone; $y++) {
                    if (mt_rand(1, Map::$_ratioObstacle) == 1) {
                        $size_x = mt_rand(1, Map::$_sizeMacObstacle);
                        $size_y = mt_rand(1, Map::$_sizeMacObstacle);
                        for ($iy = 0; $iy < $size_y; $iy++) {
                            for ($ix = 0; $ix < $size_x; $ix++) {
                                if ($y + $ix < self::WIDTH - Map::$_sizeSafeZone)
                                    Obstacle::generate($y + $ix, $i + $iy);
                            }
                        }
                    }
                }
            }
        }

        private function addObstacle()
        {
            $obstacles = Obstacle::loadAll();
            foreach ($obstacles as $v) {
                $this->_map[$v['y']][$v['x']]['object'] = new Obstacle($v['x'], $v['y']);
                $this->_map[$v['y']][$v['x']]['type'] = 1;
            }
        }

        public function getCoord($x, $y)
        {
            return $this->_map[$y][$x];
        }

        public function addShipMap($ships)
        {
            foreach ($ships as $ship) {
                if ($ship->getCurrentRotation() == 0) {
                    for ($y = 0; $y < $ship->getSizeY(); $y++) {
                        for ($x = 0; $x < $ship->getSizeX(); $x++) {
                            $this->_map[$ship->getY() - $x][$ship->getX() + $y] = $ship;
                        }
                    }
                }
                if ($ship->getCurrentRotation() == 90) {
                    for ($y = 0; $y < $ship->getSizeY(); $y++) {
                        for ($x = 0; $x < $ship->getSizeX(); $x++) {
                            $this->_map[$ship->getY() + $y][$ship->getX() + $x] = $ship;
                        }
                    }
                }
                if ($ship->getCurrentRotation() == 180) {
                    for ($y = 0; $y < $ship->getSizeY(); $y++) {
                        for ($x = 0; $x < $ship->getSizeX(); $x++) {
                            $this->_map[$ship->getY() + $x][$ship->getX() - $y] = $ship;
                        }
                    }
                }
                if ($ship->getCurrentRotation() == 270) {
                    for ($y = 0; $y < $ship->getSizeY(); $y++) {
                        for ($x = 0; $x < $ship->getSizeX(); $x++) {
                            $this->_map[$ship->getY() - $y][$ship->getX() - $x] = $ship;
                        }
                    }
                }
            }
        }

        public function getMap()
        {
            return $this->_map;
        }

        public static function doc()
        {
            $read = fopen("Map.doc.txt", 'r');
            while ($read && !feof($read))
                echo fgets($read);
        }
    }