<?php

    class WeaponFactory implements Norm42
    {
        const TABLE = 'weapon';
        const TABLE_INTER = 'maps';

        public static function loadHasShip($id){
            $stat = Mysql::getInstance()->query("
                SELECT *, peoples_has_ships_has_weapons.id AS idweapon FROM peoples_has_ships_has_weapons
                INNER JOIN weapons ON weapons.id = peoples_has_ships_has_weapons.weapons_id
                WHERE peoples_has_ships_has_weapons.peoples_has_ships_id = '".$id."'
            ");
            $res = $stat->fetchAll(PDO::FETCH_ASSOC);
            $weapons = array();
            foreach($res as $r){
                $weapons[] = self::create($r);
            }
            return $weapons;
        }

        private static function create($a) {
            $weapon = new Weapon(
                $a['idweapon'],
                $a['width_small'],
                $a['width_medium'],
                $a['width_big'],
                $a['success_small'],
                $a['success_medium'],
                $a['success_big'],
                $a['scope_small'],
                $a['scope_medium'],
                $a['scope_big'],
                $a['peoples_has_ships_id'],
                $a['active'],
                $a['charge'],
                $a['current_charge'],
                $a['name'],
                $a['motionless']
            );
            return $weapon;
        }

        public static function doc()
        {
            $read = fopen("WeaponFactory.doc.txt", 'r');
            while ($read && !feof($read))
                echo fgets($read);
        }
    }