<?php
    namespace models\users;
    use models\dataBase; 
    use PDO;
    use PDOException;

    class User {
        private $db;
        
        public function __construct(){
            $this -> db = DataBase::getInstance() -> getConnection();

            try{
                $result = $this -> db -> query('SELECT 1 FROM `users` LIMIT 1');
            } catch (PDOException $e) {
                $this -> createTable(); 
            }
        }

        private function roleExist(){
            $query = "SELECT COUNT(*) FROM `roles`";
            $stmt = $this -> db -> query($query);
            return $stmt -> fetchColumn() > 0;    
        }  

        private function adminUserExist(){
            $query = "SELECT COUNT(*) FROM `users` WHERE `username` = 'Admin' AND `is_admin` = 1";
            $stmt = $this -> db -> query($query);
            return $stmt -> fetchColumn() > 0;    
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

                if(!$this -> roleExist()){
                    $insertRolesQuery = "INSERT INTO `roles` (`role_name`, `role_description`) VALUES
                    ('Subscriber', 'Subscriber'),
                    ('Editor', 'Editor'),
                    ('Author', 'Author'),
                    ('Contributor', 'Contributor'),
                    ('Administrator', 'Administrator')";
                    $this -> db -> exec($insertRolesQuery);
                }

                if(!$this -> adminUserExist()){
                    $insertAdminQuery = "INSERT INTO `users` (`username`, `email`, `password`, `is_admin`, `role`) VALUES
                    ('Admin', 'admin@gmail.com', '\$2y\$10\$v9gmMzqA6gxP0SpSQAoJNOiV/tapzYw8kdoQIvT.KjxLkMLFeA35W', 1, 
                    (SELECT `id` FROM `roles` WHERE `role_name` = 'Administrator'))";
                    $this -> db -> exec($insertAdminQuery);
                }    
                return true;
            } catch (PDOException $e) {
                return false;
            }    
        }

        public function readAll() {
            try {
                $stmt = $this -> db -> query('SELECT * FROM users');

                $users = [];
                while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                    $users[] = $row;
                }
                return $users;
            } catch(PDOException $e) {
                return false;
            }
        }

        public function createUser($data) {
            $username = $data['username'];
            $email = $data['email'];
            $password = $data['password'];
            $role = $data['role'];
            $created_at = date('Y-m-d H:i:s');
            
            try{
                $stmt = $this -> db -> prepare('INSERT INTO users (username, email, password, role, created_at) VALUES (?,?,?,?,?)');
                $stmt -> execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $role, $created_at]);    
                return true;    
            } catch(PDOException $e) {
                return false;
            }           
        }

        public function delete($id) {
            try {
                $stmt = $this -> db -> prepare('DELETE FROM users WHERE id = ?');
                $stmt -> execute([$id]);
                return true;
            } catch(PDOException $e) {
                return false;
            } 
        }

        public function readOne($id) {
            try {
                $stmt = $this -> db -> prepare('SELECT * FROM users WHERE id = ?');
                $stmt -> execute([$id]); 
                $res = $stmt -> fetch(PDO::FETCH_ASSOC); 
                return $res; 
            } catch(PDOException $e) {
                return false;
            }    
        }

        public function update($id, $data) {
            $username = $data['username'];
            $admin = !empty($data['admin']) && $data['admin'] !== 0 ? 1 : 0;
            $email = $data['email'];
            $role = $data['role'];
            $is_active = isset($data['is_active']) ? 1 : 0;

            try {
                $stmt = $this -> db -> prepare('UPDATE users SET username = ?, email = ?,
                         admin = ?, role = ?, is_active = ? WHERE id = ?');

                $stmt -> execute([$username, $email, $admin, $role, $is_active, $id]);
                return true;
            } catch(PDOException $e) {
                return false;
            }                   
        }
    }