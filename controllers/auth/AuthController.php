<?php
    namespace controllers\auth;
    use models\AuthUser;
    use models\Check;

    class AuthController {

        private $check;

        public function __construct(){
            $userRole = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null; 
            $this -> check = new Check($userRole);    
        }

        public function register() {
            include 'app/views/auth/register.php';            
        }

        public function login() {
            include 'app/views/auth/login.php';  
        }

        public function logout(){
            session_start();
            session_unset();
            session_destroy();
            
            header("Location: /");
        } 

        public function store() {
            $this -> check -> requirePermission();
            if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
                $username = trim(htmlspecialchars($_POST['username']));
                $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];

                if ($password !== $confirm_password) {
                    echo 'Password do not match';
                    return;
                }

                $userModel = new AuthUser();
                $userModel -> register($username, $email, $password);
            }

            header("Location: /users");
        }

        public function authenticate() {
            $authModel = new AuthUser();
            
            if(isset($_POST['email']) && isset($_POST['password'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $remember = isset($_POST['remember']) ? $_POST['remember'] : '';

                $user = $authModel -> findByEmail($email);

                if($user && password_verify($password, $user['password'])) {
                   $_SESSION['user_id'] = $user['id'];
                   $_SESSION['user_role'] = $user['role'];
                   $_SESSION['user_email'] = $email;

                   if($remember == 'on') {
                        setcookie('user_email', $email, time() + (7 * 24 * 60 * 60), '/');
                        setcookie('user_password', $password, time() + (7 * 24 * 60 * 60), '/');
                   }

                   header("Location: /");
                } else {
                   echo 'Invalid email or password';     
                }
            }    
        }
    }
