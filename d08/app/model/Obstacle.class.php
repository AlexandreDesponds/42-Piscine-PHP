<?php

    class Obstacle extends Square implements Norm42
    {
        public function __construct($x, $y)
        {
            parent::__construct($x, $y);
        }

        public static function generate($x, $y)
        {
            try {
                Mysql::getInstance()->query("INSERT INTO " . Map::TABLE . " (x, y, object) VALUES ('" . $x . "', '" . $y . "', 'obstacle');");
            } catch (Exception $e) {

            }

            return (new Obstacle($x, $y));
        }

        public static function loadAll()
        {
            $stat = Mysql::getInstance()->query("SELECT x, y FROM " . Map::TABLE . " WHERE object = 'obstacle'");
            return ($stat->fetchAll(PDO::FETCH_ASSOC));
        }

        public static function doc()
        {
            $read = fopen("Obstacle.doc.txt", 'r');
            while ($read && !feof($read))
                echo fgets($read);
        }
    }