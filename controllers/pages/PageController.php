<?php
    namespace controllers\pages;

    use models\Check;
    use models\pages\Page;
    use models\roles\Role;

    class PageController {

        private $check;

        public function __construct(){
            $userRole = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null; 
            $this -> check = new Check($userRole);    
        }

        public function index() {
            $this -> check -> requirePermission();
            $pageModel = new Page();
            $pages = $pageModel -> getAllPages();
            include 'app/views/pages/index.php';            
        }

        public function create(){
            $this -> check -> requirePermission();
            $roleModel = new Role();
            $roles = $roleModel -> getAllRoles();
            include 'app/views/pages/create.php';
        }

        public function store() {
            $this -> check -> requirePermission();
            if(isset($_POST['title']) && isset($_POST['slug']) && isset($_POST['roles'])) {
                $title = trim(htmlspecialchars($_POST['title']));
                $slug = trim(htmlspecialchars($_POST['slug']));
                $roles = implode(",", $_POST['roles']);

                if (empty($title) && empty($slug) && empty($roles)) {
                    echo 'Title and slug or Role fields is required';
                    return;
                }

                $pageModel = new Page();
                $pageModel -> createPage($title, $slug, $roles);
            }
            $path = '/pages';   
            header("Location: $path");
        }

        public function edit($params) {
            $this -> check -> requirePermission();
            $roleModel = new Role();
            $roles = $roleModel -> getAllRoles();

            $pageModel = new Page();
            $page =  $pageModel -> getPageByID($params['id']);

            if(!$page) {
                echo "Page not found";
                return;
            }
            include 'app/views/pages/edit.php';  
        }

        public function update() {
            $this -> check -> requirePermission();
            if(isset($_POST['id']) && isset($_POST['title']) && isset($_POST['slug']) && isset($_POST['roles'])) {
                $id = trim($_POST['id']);
                $title = trim(htmlspecialchars($_POST['title']));
                $slug = trim(htmlspecialchars($_POST['slug']));
                $roles = implode(",", $_POST['roles']); 
                if (empty($title) && empty($slug) && empty($roles)) {
                    echo 'Title and slug is required';
                    return;
                }

                $pageModel = new Page();
                $pageModel -> updatePage($id, $title, $slug, $roles);

                $path = '/pages';   
                header("Location: $path");
            }
        }

        public function delete($params) {
            $this -> check -> requirePermission();
            $pageModel = new Page();
            $pageModel -> deletePage($params['id']);

            $path = '/pages';   
            header("Location: $path");
        }
    }
