<?php
    namespace controllers\home; 

    use models\todo\tasks\TaskModel;
    use models\users\User;
    use models\pages\Page;

    class HomeController {

        public function __construct(){
            $user = new User();
            $user -> createTable();

            $page = new Page();

            if($page -> createTable()) {
                $page -> insertPages();       
            }
        }


        public function index(){
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

            $taskModel = new TaskModel;
            $tasks = $taskModel -> getAllTasksByIdUser($user_id);
            $tasksJson = json_encode($tasks);
            include 'app/views/home/index.php';        
        }
    }