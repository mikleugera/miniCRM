<?php
    namespace models;
    use models\DataBase;
    use PDO;
    use PDOException;

    class AuthUser {
        private $db;
        
        public function __construct(){
            $this -> db = DataBase::getInstance() -> getConnection();

            try{
                $result = $this -> db -> query('SELECT 1 FROM `users` LIMIT 1');
            } catch (PDOException $e) {
                $this -> createTable(); 
            }
        }

        public function createTable(){
            $roleTableQuery = 'CREATE TABLE IF NOT EXISTS `roles` (
                `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `role_name` VARCHAR(255) NOT NULL,  
                `role_description` TEXT)';

            $userTableQuery = 'CREATE TABLE IF NOT EXISTS `users` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `username` VARCHAR(255) NOT NULL,  
                `email` VARCHAR(255) NOT NULL,  
                `email_verification` TINYINT(1) NOT NULL DEFAULT 0,  
                `password` VARCHAR(255) NOT NULL,  
                `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
                `role` INT(11) NOT NULL DEFAULT 0,
                `is_active` TINYINT(1) NOT NULL DEFAULT 1,
                `last_login` TIMESTAMP NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`role`) REFERENCES `roles`(`id`))';

            try {
                $this -> db -> exec($roleTableQuery);
                $this -> db -> exec($userTableQuery);
                return true;
            } catch (PDOException $e) {
                return false;
            }    
        }

        public function register($username, $email, $password) {
            $created_at = date('Y-m-d H:i:s');

            try {
                $stmt = $this -> db -> prepare('INSERT INTO users (username, email, password, created_at) VALUES (?,?,?,?)');
                $stmt -> execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $created_at]);
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        public function login ($email, $password) {
            try {
                $stmt = $this -> db -> prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
                $stmt -> execute([$email]);
                $user = $stmt -> fetch(PDO::FETCH_ASSOC);

                if($user && password_verify($password, $user['password'])) {
                    return $user;
                }
                return false;
            } catch (PDOException $e) {
                return false;
            }
        }

        public function findByEmail($email) {
            try {
                $stmt = $this -> db -> prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
                $stmt -> execute([$email]);
                $user = $stmt -> fetch(PDO::FETCH_ASSOC);

                return $user ? $user : false;
            } catch (PDOException $e) {
                return false;
            }
        }
    }