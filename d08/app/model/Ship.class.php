<?php

    class Ship extends square implements Norm42
    {
        use Convert;

        private $_id;
        private $_player;
        private $_model;
        private $_name;
        private $_sizeX;
        private $_sizeY;
        private $_sprit;
        private $_color;
        private $_life;
        private $_pp;
        private $_speed;
        private $_maneuverability;
        private $_shield;
        private $_x;
        private $_y;
        private $_currentLife;
        private $_currentPp;
        private $_currentShield;
        private $_currentRotation;
        private $_sleep;
        private $_currentActive;
        private $_firstTurn;
        private $_currentManeuverability;
        private $_currentSpeed;
        private $_step;
        private $_weapons = array();

        const TABLE = 'peoples_has_ships';

        public function __construct($_id, $_player, $_model, $_name, $_sizeX, $_sizeY, $_sprit, $_color, $_life, $_pp, $_speed, $_maneuverability, $_shield, $_x, $_y, $_currentLife, $_currentPp, $_currentShield, $_currentRotation, $_active, $_currentActive, $_firstTurn, $_currentSpeed, $_currentManeuverability, $_step)
        {
            $this->_id = $_id;
            $this->_player = $_player;
            $this->_model = $_model;
            $this->_name = $_name;
            $this->_sizeX = $_sizeX;
            $this->_sizeY = $_sizeY;
            $this->_sprit = $_sprit;
            $this->_color = $_color;
            $this->_life = $_life;
            $this->_pp = $_pp;
            $this->_speed = $_speed;
            $this->_maneuverability = $_maneuverability;
            $this->_shield = $_shield;
            $this->_player = $_player;
            $this->_x = $_x;
            $this->_y = $_y;
            $this->_currentLife = $_currentLife;
            $this->_currentPp = $_currentPp;
            $this->_currentShield = $_currentShield;
            $this->_currentRotation = $_currentRotation;
            $this->_currentSpeed = $_currentSpeed;
            $this->_currentManeuverability = $_currentManeuverability;
            $this->_sleep = $_active;
            $this->_currentActive = $_currentActive;
            $this->_firstTurn = $_firstTurn;
            $this->_step = $_step;

            $this->_weapons = WeaponFactory::loadHasShip($this->_id);
        }

        public function turn($dir)
        {
            if ($dir == 1) {
                $this->_currentRotation += 90;
            } else if ($dir == -1)
                $this->_currentRotation -= 90;
            if ($this->_currentRotation == -90)
                $this->_currentRotation = 270;
            if ($this->_currentRotation == 360)
                $this->_currentRotation = 0;

            $this->_firstTurn = 1;
            $this->save();
        }

        public function stopMove()
        {
            $this->_currentSpeed = 0;
            $this->_step = 2;
            $this->save();
        }

        public function move($case)
        {
            //TODO : refaire le check colision
            $obstacle = Obstacle::loadAll();

            for ($i = 0; $i < $case; $i++) {
                if ($this->_currentRotation == 0) {
                    $this->_y -= 1;
                } elseif ($this->_currentRotation == 90) {
                    $this->_x += 1;
                } elseif ($this->_currentRotation == 180) {
                    $this->_y += 1;
                } elseif ($this->_currentRotation == 270) {
                    $this->_x -= 1;
                }
                if (!$this->moveIsPossible($obstacle)) {
                    $this->delete();
                    return;
                }
            }
            $this->_currentSpeed -= $case;
            $this->_firstTurn = 1;
            if ($this->_currentSpeed <= 0)
                $this->stopMove();
            $this->save();
        }

        private function moveIsPossible($obstacle)
        {
            foreach ($obstacle as $v) {
                if ($this->_x == $v['x'] && $this->_y == $v['y'])
                    return false;
            }
            return true;
        }

        public function addShield()
        {
            if ($this->_currentPp > 0) {
                $this->_currentPp = $this->_currentPp - 1;
                $this->_currentShield = $this->_currentShield + 1;
                $this->save();
            }
        }

        public function touch(){
            if ($this->_currentShield > 0)
                $this->_currentShield--;
            else
                $this->_currentLife--;
            if ($this->_currentLife <= 0)
                return $this->delete();
            $this->save();
        }

        public function addSpeed()
        {
            if ($this->_currentPp > 0) {
                $this->_currentPp = $this->_currentPp - 1;
                $this->_currentSpeed = $this->_currentSpeed + Dice::cast();
                $this->save();
            }
        }

        public function ppStop()
        {
            $this->_step = 1;
            $this->save();
        }

        public function asSleep()
        {
            $this->_sleep = 1;
            $this->_currentActive = 0;
            $this->save();
        }

        public function active()
        {
            if ($this->_sleep == 0) {
                $this->_currentSpeed = $this->_speed;
                $this->_currentShield = $this->_shield;
                $this->_currentPp = $this->_pp;
                $this->_currentActive = 1;
                $this->_firstTurn = 0;
                $this->_step = 0;
                $this->save();
            }
        }

        public function addCharge($idWeapon){
            if ($this->_currentPp > 0) {
                $this->_currentPp--;
                foreach ($this->_weapons as $w) {
                    if ($w->getId() == $idWeapon)
                        $w->addCharge();
                }
                $this->save();
            }
        }

        public function wakeup()
        {
            $this->_sleep = 0;
            $this->_currentActive = 0;
            $this->_step = 0;
            foreach ($this->_weapons as $w) {
                $w->wakeup();
            }
            $this->save();
        }

        public function delete()
        {
            Mysql::getInstance()->query("SET foreign_key_checks = 0;DELETE FROM " . self::TABLE . " WHERE id = " . $this->_id.";SET foreign_key_checks = 1;");
        }

        private function save()
        {
            Mysql::getInstance()->query("
            UPDATE " . Ship::TABLE . " SET
            x = '" . $this->_x . "',
            y = '" . $this->_y . "',
            current_pp = '" . $this->_currentPp . "',
            current_life = '" . $this->_currentLife . "',
            current_rotation = '" . $this->_currentRotation . "',
            active = '" . $this->_sleep . "',
            current_active = '" . $this->_currentActive . "',
            firstturn = '" . $this->_firstTurn . "',
            current_speed = '" . $this->_currentSpeed . "',
            current_shield = '" . $this->_currentShield . "',
            current_maneuverability = '" . $this->_currentManeuverability . "',
            step = '" . $this->_step . "'
            WHERE id = '" . $this->_id . "'
            ");
        }

        public function getCaseFire($idWeapon)
        {
            foreach ($this->_weapons as $w) {
                if ($w->getId() == $idWeapon)
                    return $w->getCaseFire($this);
            }
            return false;
        }

        public function fire($idWeapon, $game) {
            foreach ($this->_weapons as $w) {
                if ($w->getId() == $idWeapon)
                    return $w->fire($this, $game);
            }
            return false;
        }

        public function getX()
        {
            return $this->_x;
        }

        public function getY()
        {
            return $this->_y;
        }

        public function getCurrentRotation()
        {
            return $this->_currentRotation;
        }

        public function getSizeX()
        {
            return $this->_sizeX;
        }

        public function getSizeY()
        {
            return $this->_sizeY;
        }

        public function getColor()
        {
            return $this->_color;
        }

        public function getId()
        {
            return $this->_id;
        }

        public function getFirstTurn()
        {
            return $this->_firstTurn;
        }

        public function setFirstTurn($firstTurn)
        {
            $this->_firstTurn = $firstTurn;
        }

        public function getCurrentActive()
        {
            return $this->_currentActive;
        }

        public function getCurrentSpeed()
        {
            return $this->_currentSpeed;
        }

        public function getManeuverability()
        {
            return $this->_maneuverability;
        }

        public function getCurrentPp()
        {
            return $this->_currentPp;
        }

        public function getCurrentShield()
        {
            return $this->_currentShield;
        }

        public function getSleep()
        {
            return $this->_sleep;
        }

        public function getPlayer()
        {
            return $this->_player;
        }

        public function getWeapons()
        {
            return $this->_weapons;
        }

        public function getStep()
        {
            return $this->_step;
        }

        public function setStep($step)
        {
            $this->_step = $step;
        }

        public static function doc()
        {
            $read = fopen("Ship.doc.txt", 'r');
            while ($read && !feof($read))
                echo fgets($read);
        }
    }