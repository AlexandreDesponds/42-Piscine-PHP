<?php

    class ShipFactory implements Norm42
    {
        const TABLE = 'ships';
        const TABLE_INTER = 'maps';

        public static function load($id){
            $stat = Mysql::getInstance()->query("
                SELECT *, peoples_has_ships.id AS idship FROM peoples_has_ships
                INNER JOIN peoples ON peoples.id = peoples_has_ships.peoples_id
                INNER JOIN ships ON ships.id = peoples_has_ships.ships_id
                WHERE peoples_has_ships.id = '".$id."'
            ");
            $res = $stat->fetch(PDO::FETCH_ASSOC);
            $ship = self::create($res);
            return $ship;
        }

        public static function loadAll(){
            $stat = Mysql::getInstance()->query("
                SELECT *, peoples_has_ships.id AS idship FROM peoples_has_ships
                INNER JOIN peoples ON peoples.id = peoples_has_ships.peoples_id
                INNER JOIN ships ON ships.id = peoples_has_ships.ships_id
            ");
            $res = $stat->fetchAll(PDO::FETCH_ASSOC);
            $ships = array();
            foreach ($res as $v) {
                $ships[] = self::create($v);
            }
            return $ships;
        }

        private static function create($a) {
            $ship = new Ship(
                $a['idship'],
                $a['peoples_id'],
                $a['ships_id'],
                $a['name'],
                $a['sizeX'],
                $a['sizeY'],
                $a['sprit'],
                $a['color'],
                $a['life'],
                $a['pp'],
                $a['speed'],
                $a['maneuverability'],
                $a['shield'],
                $a['x'],
                $a['y'],
                $a['current_life'],
                $a['current_pp'],
                $a['current_shield'],
                $a['current_rotation'],
                $a['active'],
                $a['current_active'],
                $a['firstturn'],
                $a['current_speed'],
                $a['current_maneuverability'],
                $a['step']
            );
            return $ship;
        }

        public static function doc()
        {
            $read = fopen("ShipFactory.doc.txt", 'r');
            while ($read && !feof($read))
                echo fgets($read);
        }
    }