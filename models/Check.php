<?php
    namespace models;
    use models\pages\Page;

    class Check {

        private $userRole;

        public function __construct($userRole) 
        {
            $this -> userRole = $userRole;
        }


        public function getCurrentURLSlug(){
            $url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $parseURI = parse_url($url);
            $path = $parseURI['path'];       
            $segments = explode('/', ltrim($path, '/'));
            $twoSegments = array_slice($segments, 0, 2);
            $slug = implode('/', $twoSegments); 
            return $slug;
        }

        public function checkPermission($slug) {
            //Получити інформацію про сторінку по slug
            $pageModel = new Page();
            $page = $pageModel -> findBySlug($slug);

            if(!$page) {
                return false;
            }
            //Получити дозвіл ролі для сторінки
            $allowedRoles = explode(',', $page['role']);
            if(isset($this -> userRole) && in_array($this -> userRole, $allowedRoles)){
                return true;
            } else { 
                return false;
            }    
        }

        public function requirePermission() {
            if(!ENABLE_PERMISSION_CHECK){
                return;
            }
            $slug = $this -> getCurrentURLSlug();
            if(!$this -> checkPermission($slug)) {
                   
                header("Location: /");
                exit();
            }
        }

        public function isCurrentUserRole($role) {
            return $this -> userRole = $role;     
        }
    }