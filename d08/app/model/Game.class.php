<?php

    class Game implements Norm42
    {
        use Convert;

        private $_map;
        private $_ships;

        public function __construct()
        {
            $this->_map = new Map();
            $this->_ships = ShipFactory::loadAll();
            if ($this->checkEndTurn())
                $this->newTurn();

            $this->_map->addShipMap($this->_ships);
        }

        public function possibleActivation() {
            foreach($this->_ships as $s) {
                if ($s->getCurrentActive() == 1)
                    return false;
            }
            return true;
        }

        private function checkEndTurn()
        {
            foreach($this->_ships as $s) {
                if ($s->getSleep() == 0)
                    return false;
            }
            return true;
        }

        private function newTurn(){
            foreach($this->_ships as $s) {
                $s->wakeup();
            }
        }

        public function getMap()
        {
            return $this->_map;
        }

        public function getShips()
        {
            return $this->_ships;
        }

        public function getShipArray()
        {
            $ret = array();
            foreach ($this->_ships as $ship) {
                $ret[] = $ship->toArray();
            }
            return $ret;
        }

        public static function doc()
        {
            $read = fopen("Game.doc.txt", 'r');
            while ($read && !feof($read))
                echo fgets($read);
        }

    }