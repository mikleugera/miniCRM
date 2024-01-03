<?php
    namespace models\todo\category;
    use models\Database;
    use PDO;
    use PDOException;

    class CategoryModel {
        private $db;
        private $user_id;

        
        public function __construct(){
            $this -> db = DataBase::getInstance() -> getConnection();
            $this -> user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; 
            
            try{
                $result = $this -> db -> query('SELECT 1 FROM `todo_category` LIMIT 1');
            } catch (PDOException $e) {
                $this -> createTable(); 
            }
        }

        public function createTable(){
            $query = 'CREATE TABLE IF NOT EXISTS `todo_category` (
                `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) NOT NULL,  
                `description` TEXT,
                `usability` TINYINT DEFAULT 1,
                `user` INT NOT NULL,
                FOREIGN KEY (user) REFERENCES users(id) ON DELETE CASCADE
                )';
            try {
                $this -> db -> exec($query);
                return true;
            } catch (PDOException $e) {
                return false;
            }    
        } 

        public function getAllCategories() {
            try {
                $stmt = $this -> db -> prepare('SELECT * FROM todo_category WHERE user = ?');
                $stmt -> execute([$this -> user_id]);
                $todo_category = [];
               while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                   $todo_category[] = $row;
               } 

               return $todo_category;
            } catch(PDOException $e) {
                return false;
            }
        }

        public function getAllCategoriesWithUsability() {
            try {
                $stmt = $this -> db -> prepare('SELECT * FROM todo_category WHERE user = ? AND usability = 1');
                $stmt -> execute([$this -> user_id]);
                $todo_category = [];
               while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                   $todo_category[] = $row;
               } 

               return $todo_category;
            } catch(PDOException $e) {
                return false;
            }
        }

        public function createCategory($title, $description, $user_id) {
            try {
                $stmt = $this -> db -> prepare('INSERT INTO todo_category (title, description, user) VALUES (?,?,?)');
                $stmt -> execute([$title, $description, $user_id]);
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        public function CategoryByID($id) {
            try {
                $stmt = $this -> db -> prepare('SELECT * FROM todo_category WHERE id = ?');
                $stmt -> execute([$id]);
                $todo_category = $stmt -> fetch(PDO::FETCH_ASSOC);

                return $todo_category ? $todo_category : false;
            } catch (PDOException $e) {
                return false;
            }
        }
        
        public function updateCategory($id, $title, $description, $usability) {
            try {
                $stmt = $this -> db -> prepare('UPDATE todo_category SET title = ?, description = ?, usability = ? WHERE id = ?');
                $stmt -> execute([$title, $description, $usability, $id]);

                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        public function deleteCategory($id) {
            try {
                $stmt = $this -> db -> prepare('DELETE FROM todo_category WHERE id = ?');
                $stmt -> execute([$id]);

                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
    }