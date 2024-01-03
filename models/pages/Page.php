<?php
    namespace models\pages;
    
    use models\DataBase;
    use models\roles\Role;
    use PDOException;
    use PDO;

    class Page {
        private $db;
        
        public function __construct(){
            $this -> db = DataBase::getInstance() -> getConnection();

            try{
                $result = $this -> db -> query('SELECT 1 FROM `pages` LIMIT 1');
            } catch (PDOException $e) {
                $this -> createTable(); 
            }
        }

        public function createTable(){
            $roleTableQuery = 'CREATE TABLE IF NOT EXISTS `pages` (
                `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) NOT NULL,  
                `slug` VARCHAR(255) NOT NULL,  
                `role` VARCHAR(255) NOT NULL,  
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
                `update_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)
                 ENGINE=InnoDB DEFAULT CHARSET=utf8mb4';

            try {
                $this -> db -> exec($roleTableQuery);
                return true;
            } catch (PDOException $e) {
                return false;
            }    
        }

        public function insertPages() {
            $insertPagesQuery = "INSERT INTO `pages` (`id`, `title`, `slug`, `role`, `created_at`, `update_at`) VALUES 
                (1, 'Home', '/', '1,2,3,4,5', '2003-01-01 00:00:01', '2000-01-01 00:00:02'),
                (2, 'Users', 'users', '1,2,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (3, 'Pages', 'pages', '5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (4, 'User edit', 'users/edit', '2,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (5, 'User create', 'users/create', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (6, 'Users store', 'users/store', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (7, 'Users update', 'users/update', '5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (8, 'Roles', 'roles', '2,3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (9, 'Roles create', 'roles/create', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (10, 'Roles store', 'roles/store', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (11, 'Roles edit', 'roles/edit', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (12, 'Roles update', 'roles/update', '5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (13, 'Pages update', 'pages/update', '5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (14, 'Users delete', 'users/delete', '5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (15, 'Todo category create', 'todo/category/create', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (16, 'Todo category edit', 'todo/category/edit', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (17, 'Todo category', 'todo/category', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (18, 'Todo category store', 'todo/category/store', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (19, 'Todo category delete', 'todo/category/delete', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (20, 'Todo category update', 'todo/category/update', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (21, 'Tasks', 'todo/tasks', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (22, 'Task create', 'todo/tasks/create', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (23, 'Todo task store', 'todo/tasks/store', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (24, 'Tasks update', 'todo/tasks/update', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (25, 'Tasks delete', 'todo/tasks/delete', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (26, 'Tasks edit', 'todo/tasks/edit', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (27, 'Tasks completed', 'todo/tasks/completed', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (28, 'Expired tasks', 'todo/tasks/expired', '3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (29, 'Pages create', 'pages/create', '5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (30, 'Pages edit', 'pages/edit', '5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (31, 'Pages delete', 'pages/delete', '5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (32, 'Pages store', 'pages/store', '5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (33, 'Roles delete', 'roles/delete', '5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (34, 'Todo tasks task', 'todo/tasks/task', '2,3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02'),
                (35, 'Todo tasks by tag', 'todo/tasks/by-tag', '2,3,4,5', '2000-01-01 00:00:01', '2000-01-01 00:00:02')";

                try{
                    $this -> db -> exec($insertPagesQuery);
                    return true;
                } catch (PDOException $e){
                    return false;
                }

                
        }

        public function getAllPages() {
            try {
                $stmt = $this -> db -> query('SELECT * FROM pages');
               $pages = [];
               while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                   $pages[] = $row;
               }   
               return $pages;
            } catch(PDOException $e) {
                return false;
            }
        }

        public function createPage($title, $slug, $roles) {
            try {
                $stmt = $this -> db -> prepare('INSERT INTO pages (title, slug, role) VALUES (?,?,?)');
                $stmt -> execute([$title, $slug, $roles]);
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        public function getPageByID($id) {
            try {
                $stmt = $this -> db -> prepare('SELECT * FROM pages WHERE id = ?');
                $stmt -> execute([$id]);
                $page = $stmt -> fetch(PDO::FETCH_ASSOC);

                return $page ? $page : false;
            } catch (PDOException $e) {
                return false;
            }
        }

        public function findBySlug($slug) {
            try {
                $stmt = $this -> db -> prepare('SELECT * FROM pages WHERE slug = ?');
                $stmt -> execute([$slug]);
                $page = $stmt -> fetch(PDO::FETCH_ASSOC);

                return $page ? $page : false;
            } catch (PDOException $e) {
                return false;
            }
        }
        
        public function updatePage($id, $title, $slug, $roles) {
            try {
                $stmt = $this -> db -> prepare('UPDATE pages SET title = ?, slug = ?, role = ? WHERE id = ?');
                $stmt -> execute([$title, $slug, $roles, $id]);

                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        public function deletePage($id) {
            try {
                $stmt = $this -> db -> prepare('DELETE FROM pages WHERE id = ?');
                $stmt -> execute([$id]);

                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
    }