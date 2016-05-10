<?php

    class Mysql implements Norm42
    {
        private $PDOInstance = null;
        private static $instance = null;

        const SQL_USER = 'xxx';
        const SQL_HOST = 'xxx';
        const SQL_PASSWORD = 'xxx';
        const SQL_DB = 'd08';

        private function __construct()
        {
            try {
                $this->PDOInstance = new \PDO('mysql:host=' . self::SQL_HOST . ';dbname=' . self::SQL_DB, self::SQL_USER, self::SQL_PASSWORD);
                $this->PDOInstance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }

        public static function getInstance()
        {
            if(is_null(self::$instance))
            {
                self::$instance = new Mysql();
            }
            return self::$instance;
        }

        public function query($query)
        {
            return $this->PDOInstance->query($query);
        }

        public static function doc()
        {
            $read = fopen("Mysql.doc.txt", 'r');
            while ($read && !feof($read))
                echo fgets($read);
        }
    }
