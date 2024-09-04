<?php

    class DB
    {
        public $db;

        public function __construct()
        {
            $this->db = $this->createConnection();
        }
        
        private function createConnection(){
            $pdo = new PDO("mysql:host=localhost;dbname=login", 'root', '');
            $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
            return $pdo;
        }
    }

?>
