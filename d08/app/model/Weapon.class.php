<?php

    class Weapon implements Norm42
    {
        use Convert;

        private $_id;
        private $_widthSmall;
        private $_widthMedium;
        private $_widthBig;
        private $_successSmall;
        private $_successMedium;
        private $_successBig;
        private $_scopeSmall;
        private $_scopeMedium;
        private $_scopeLarge;
        private $_shipId;
        private $_active;
        private $_charge;
        private $_currentCharge;
        private $_name;
        private $_motionless;

        public function __construct($_id, $_widthSmall, $_widthMedium, $_widthBig, $_successSmall, $_successMedium, $_successBig, $_scopeSmall, $_scopeMedium, $_scopeLarge, $_shipId, $_active, $_charge, $_currentCharge, $_name, $_motionless)
        {
            $this->_id = $_id;
            $this->_widthSmall = $_widthSmall;
            $this->_widthMedium = $_widthMedium;
            $this->_widthBig = $_widthBig;
            $this->_successSmall = $_successSmall;
            $this->_successMedium = $_successMedium;
            $this->_successBig = $_successBig;
            $this->_scopeSmall = $_scopeSmall;
            $this->_scopeMedium = $_scopeMedium;
            $this->_scopeLarge = $_scopeLarge;
            $this->_shipId = $_shipId;
            $this->_active = $_active;
            $this->_charge = $_charge;
            $this->_currentCharge = $_currentCharge;
            $this->_name = $_name;
            $this->_motionless = $_motionless;
        }

        public function getCaseFire(Ship $ship)
        {
            $case = array();
            $height = 1;
            $offsetX = $ship->getX();
            $offsetY = $ship->getY();
            $sizeY2 = round(($ship->getSizeY() - 1) / 2);
            $sizeX = $ship->getSizeX();
            for ($w = 0; $w < $this->_scopeSmall; $w++) {
                $height = $height + $this->_widthSmall;
                $case[] = array('x' => $w, 'y' => 0, 'v' => 1);
                for ($h = 1; $h < $height; $h++) {
                    $case[] = array('x' => $w, 'y' => $h, 'v' => 1);
                    $case[] = array('x' => $w, 'y' => -$h, 'v' => 1);
                }
            }
            for ($w = $this->_scopeSmall; $w < $this->_scopeMedium + $this->_scopeSmall; $w++) {
                $height = $height + $this->_widthMedium;
                $case[] = array('x' => $w, 'y' => 0, 'v' => 2);
                for ($h = 1; $h < $height; $h++) {
                    $case[] = array('x' => $w, 'y' => $h, 'v' => 2);
                    $case[] = array('x' => $w, 'y' => -$h, 'v' => 2);
                }
            }
            for ($w = $this->_scopeSmall + $this->_scopeMedium; $w < $this->_scopeLarge + $this->_scopeSmall + $this->_scopeMedium; $w++) {
                $height = $height + $this->_widthBig;
                $case[] = array('x' => $w, 'y' => 0, 'v' => 3);
                for ($h = 1; $h < $height; $h++) {
                    $case[] = array('x' => $w, 'y' => $h, 'v' => 3);
                    $case[] = array('x' => $w, 'y' => -$h, 'v' => 3);
                }
            }
            if ($ship->getCurrentRotation() == 90) {
                foreach ($case as $k => $v) {
                    $case[$k]['y'] = $v['y'] + $offsetY + $sizeY2;
                    $case[$k]['x'] = $v['x'] + $offsetX + $sizeX;
                    if ($case[$k]['x'] < 0 || $case[$k]['x'] > Map::WIDTH - 1 || $case[$k]['y'] < 0 || $case[$k]['y'] > Map::HEIGHT - 1)
                        unset($case[$k]);
                }
            }
            if ($ship->getCurrentRotation() == 270) {
                foreach ($case as $k => $v) {
                    $case[$k]['y'] = $v['y'] + $offsetY - $sizeY2;
                    $case[$k]['x'] = -$v['x'] + $offsetX - $sizeX;
                    if ($case[$k]['x'] < 0 || $case[$k]['x'] > Map::WIDTH - 1 || $case[$k]['y'] < 0 || $case[$k]['y'] > Map::HEIGHT - 1)
                        unset($case[$k]);
                }
            }
            if ($ship->getCurrentRotation() == 0) {
                foreach ($case as $k => $v) {
                    $case[$k]['x'] = $v['y'] + $offsetX + $sizeY2;
                    $case[$k]['y'] = -$v['x'] + $offsetY - $sizeX;
                    if ($case[$k]['x'] < 0 || $case[$k]['x'] > Map::WIDTH - 1 || $case[$k]['y'] < 0 || $case[$k]['y'] > Map::HEIGHT - 1)
                        unset($case[$k]);
                }
            }
            if ($ship->getCurrentRotation() == 180) {
                foreach ($case as $k => $v) {
                    $case[$k]['x'] = $v['y'] + $offsetX - $sizeY2;
                    $case[$k]['y'] = $v['x'] + $offsetY + $sizeX;
                    if ($case[$k]['x'] < 0 || $case[$k]['x'] > Map::WIDTH - 1 || $case[$k]['y'] < 0 || $case[$k]['y'] > Map::HEIGHT - 1)
                        unset($case[$k]);
                }
            }
            return ($case);
        }

        public function fire($ship, Game $game)
        {
            $touch = array();
            $cases = $this->getCaseFire($ship);
            for ($i = 0; $i <= $this->_currentCharge; $i++) {
                $life = 0;
                $dice = Dice::cast();
                if ($dice >= $this->_successBig)
                    $dice = 3;
                else if ($dice >= $this->_successBig)
                    $dice = 2;
                else if ($dice >= $this->_successBig)
                    $dice = 1;
                foreach ($cases as $case) {
                    if ($case['v'] <= $dice) {
                        $fire = $game->getMap()->getCoord($case['x'], $case['y']);
                        if ($fire instanceof Ship)
                            $touch[$fire->getId()] = $fire;
                    }
                }
                foreach ($touch as $t) {
                    $t->touch($life);
                }
            }
            $this->_active = 1;
            $this->save();
        }

        public function addCharge(){
            $this->_currentCharge++;
            $this->save();
        }

        public function wakeup()
        {
            $this->_active = 0;
            $this->_currentCharge = $this->_charge;
            $this->save();
        }

        private function save()
        {
            Mysql::getInstance()->query("
            UPDATE peoples_has_ships_has_weapons SET
            active = '" . $this->_active . "',
            current_charge = '" . $this->_currentCharge . "'
            WHERE id = '" . $this->_id . "'
            ");
        }

        public function getName()
        {
            return $this->_name;
        }

        public function getCurrentCharge()
        {
            return $this->_currentCharge;
        }

        public function getCharge()
        {
            return $this->_charge;
        }

        public function getId()
        {
            return $this->_id;
        }

        public function getActive()
        {
            return $this->_active;
        }

        public static function doc()
        {
            $read = fopen("Weapon.doc.txt", 'r');
            while ($read && !feof($read))
                echo fgets($read);
        }
    }