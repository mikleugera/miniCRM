<?php
    namespace models\roles;
    use models\Database;

    class Role {
        private $db;
        
        public function __construct(){
            $this -> db = DataBase::getInstance() -> getConnection();

            try{
                $result = $this -> db -> query('SELECT 1 FROM `roles` LIMIT 1');
            } catch (\PDOException $e) {
                $this -> createTable(); 
            }
        }

        public function createTable(){
            $roleTableQuery = 'CREATE TABLE IF NOT EXISTS `roles` (
                `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `role_name` VARCHAR(255) NOT NULL,  
                `role_description` TEXT)';

            try {
                $this -> db -> exec($roleTableQuery);
                return true;
            } catch (\PDOException $e) {
                return false;
            }    
        }

        public function getAllRoles() {
            try {
                $stmt = $this -> db -> query('SELECT * FROM roles');
               $roles = [];
               while($row = $stmt -> fetch(\PDO::FETCH_ASSOC)) {
                   $roles[] = $row;
               }   
               return $roles;
            } catch(\PDOException $e) {
                return false;
            }
        }

        public function createRole($role_name, $role_description) {
            try {
                $stmt = $this -> db -> prepare('INSERT INTO roles (role_name, role_description) VALUES (?,?)');
                $stmt -> execute([$role_name, $role_description]);
                return true;
            } catch (\PDOException $e) {
                return false;
            }
        }

        public function getRoleByID($id) {
            try {
                $stmt = $this -> db -> prepare('SELECT * FROM roles WHERE id = ?');
                $stmt -> execute([$id]);
                $role = $stmt -> fetch(\PDO::FETCH_ASSOC);

                return $role ? $role : false;
            } catch (\PDOException $e) {
                return false;
            }
        }
        
        public function updateRole($id, $role_name, $role_description) {
            try {
                $stmt = $this -> db -> prepare('UPDATE roles SET role_name = ?, role_description = ? WHERE id = ?');
                $stmt -> execute([$role_name, $role_description, $id]);

                return true;
            } catch (\PDOException $e) {
                return false;
            }
        }

        public function deleteRole($id) {
            try {
                $stmt = $this -> db -> prepare('DELETE FROM roles WHERE id = ?');
                $stmt -> execute([$id]);

                return true;
            } catch (\PDOException $e) {
                return false;
            }
        }
    }