<?php

    class DB
    {
        public $db;

        public function __construct()
        {
            $this->db = $this->createConnection();
        }
        
        private function createConnection(){
            $pdo = new PDO("mysql:host=localhost;dbname=login", 'root', '', [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
            $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
            return $pdo;
        }

        public static function insert_log($log_type, $descripcion, $user_id = null, $fecha = null){
            $fechaToInsert = $fecha ? $fecha : date('Y-m-d');
            $tables_by_type = array(
                'create_user_success' => 'usuarios',
                'create_user_error' => 'usuarios',
                'delete_user_success' => 'usuarios',
                'delete_user_error' => 'usuarios',
                'login_user_error' => 'usuarios',
                'login_user_success' => 'usuarios',
                'register_user_success' => 'usuarios',
                'register_user_error' => 'usuarios',
                'restore_user_success' => 'usuarios',
                'restore_user_error' => 'usuarios'
            );
            $ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] 
                : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) 
                ? $_SERVER['HTTP_X_FORWARDED_FOR'] 
                : $_SERVER['REMOTE_ADDR']);
            $affected_table = $tables_by_type[$log_type];
            $db = new DB();
            $sql = "INSERT INTO logs (fecha, usuario_id, accion, descripcion, ip, tabla_afectada) VALUES (?, ?, ?, ?, ?, ?)";
            $query = $db->db->prepare($sql);
            $query->execute([$fechaToInsert, $user_id, $log_type, $descripcion, $ip, $affected_table]);
        }


        public static function getLogs(){
            $db = new DB();
            $sql = "SELECT * FROM logs";
            $query = $db->db->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        }
    }


?>
