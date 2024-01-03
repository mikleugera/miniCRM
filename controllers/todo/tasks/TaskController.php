<?php
    namespace controllers\todo\tasks;

    use DateInterval;
    use DateTime;
    use models\Check;
    use models\todo\tasks\TaskModel;
    use models\todo\tasks\TagsModel;
    use models\todo\category\CategoryModel;
    
    class TaskController {

        private $check;
        private $tagsModel;

        public function __construct(){
            $userRole = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null; 
            $this -> check = new Check($userRole);            
            $this -> tagsModel = new TagsModel;
        }

        public function index() {
            $this -> check -> requirePermission();
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

            $todoTasksModel = new TaskModel();
            $tasks = $todoTasksModel -> getAllTasksByIdUser($user_id);

            $categoryModel = new CategoryModel();

            foreach($tasks as &$task) {
                $task['tags'] = $this -> tagsModel -> getTagsByTaskId($task['id']);
                $task['category'] = $categoryModel -> CategoryByID($task['category_id']);      
            };
            
            include 'app/views/todo/tasks/index.php';            
        }

        public function completed() {
            $this -> check -> requirePermission();
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

            $todoTasksModel = new TaskModel();
            $completedTasks = $todoTasksModel -> getAllCompletedTasksByIdUser($user_id);

            $categoryModel = new CategoryModel();

            foreach($completedTasks as &$task) {
                $task['tags'] = $this -> tagsModel -> getTagsByTaskId($task['id']);
                $task['category'] = $categoryModel -> CategoryByID($task['category_id']);      
            };

            include 'app/views/todo/tasks/completed.php';            
        }

        public function expired() {
            $this -> check -> requirePermission();
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

            $todoTasksModel = new TaskModel();
            $expiredTasks = $todoTasksModel -> getAllExpiredTasksByIdUser($user_id);

            $categoryModel = new CategoryModel();

            foreach($expiredTasks as &$task) {
                $task['tags'] = $this -> tagsModel -> getTagsByTaskId($task['id']);
                $task['category'] = $categoryModel -> CategoryByID($task['category_id']);      
            };

            include 'app/views/todo/tasks/expired.php';            
        }

        public function create(){
            $this -> check -> requirePermission();

            $todoCategoryModel = new CategoryModel();
            $categories = $todoCategoryModel -> getAllCategoriesWithUsability();

            include 'app/views/todo/tasks/create.php';
        }

        public function store() {
            $this -> check -> requirePermission();
            if(isset($_POST['title']) && isset($_POST['category_id']) && isset($_POST['finish_date'])) {
                $data['title'] = trim(htmlspecialchars($_POST['title']));
                $data['category_id'] = trim(htmlspecialchars($_POST['category_id']));
                $data['finish_date'] = trim(htmlspecialchars($_POST['finish_date']));
                $data['user_id'] = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
                $data['status'] = 'new';
                $data['priority'] = 'low';

                $todoTasksModel = new TaskModel();
                $todoTasksModel -> createTask($data);
            }
            $path = '/todo/tasks';
            header("Location: $path");
        }

        public function edit($params) {
            $this -> check -> requirePermission();
            $todoTaskModel = new TaskModel();
            $task =  $todoTaskModel -> getTaskById($params['id']);

            $task_id = isset($params['id']) ? intval($params['id']) : 0;
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; 

            if(!$task || $task['user_id'] != $user_id) {
                http_response_code(404);
                include 'app/views/errors/404.php';
                return; 
            }

            $todoCategoryModel = new CategoryModel();
            $categories = $todoCategoryModel -> getAllCategoriesWithUsability();

            if(!$task) {
                echo "Task not found";
                return;
            }

            $tags = $this -> tagsModel -> getTagsByTaskId($task['id']); 
            
            include 'app/views/todo/tasks/edit.php';  
        }

        public function tasksByTag($params) {
            $this -> check -> requirePermission();

            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

            $taskModel = new TaskModel();
            $taskByTag =  $taskModel -> getTasksByTagId($params['id'], $user_id);

            $tagsModel = new TagsModel();
            $tagname = $tagsModel -> getTagNameById($params['id']);

            $categoryModel = new CategoryModel();

            foreach($taskByTag as &$task) {
                $task['tags'] = $this -> tagsModel -> getTagsByTaskId($task['task_id']);
                $task['category'] = $categoryModel -> CategoryByID($task['category_id']);      
            };
            
            include 'app/views/todo/tasks/by-tag.php';  
        }

        public function update() {
            
            $this -> check -> requirePermission();
            if(isset($_POST['title']) && isset($_POST['category_id']) && isset($_POST['finish_date'])) {
                $data['id'] = $_POST['id'];
                $data['title'] = trim(htmlspecialchars($_POST['title']));
                $data['category_id'] = trim(htmlspecialchars($_POST['category_id']));
                $data['finish_date'] = trim(htmlspecialchars($_POST['finish_date']));
                $data['reminder_at'] = trim(htmlspecialchars($_POST['reminder_at']));
                $data['status'] = trim(htmlspecialchars($_POST['status']));
                $data['priority'] = trim(htmlspecialchars($_POST['priority']));
                $data['description'] = trim(htmlspecialchars($_POST['description']));
                $data['user_id'] = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

                $finish_date_value = $data['finish_date'];
                $reminder_at_option = $data['reminder_at'];
                $finish_date = new DateTime($finish_date_value);

                switch($reminder_at_option){
                    case '30_minutes':
                        $interval = new DateInterval('PT30M');
                        break;    
                    case '1_hour':
                        $interval = new DateInterval('PT1H');
                        break;    
                    case '2_hours':
                        $interval = new DateInterval('PT2H');
                        break;    
                    case '12_hours':
                        $interval = new DateInterval('PT12H');
                        break;    
                    case '24_hours':
                        $interval = new DateInterval('P1D');
                        break;    
                    case '7_days':
                        $interval = new \DateInterval('P7D');
                        break;    
                }

                $reminder_at = $finish_date -> sub($interval);

                $data['reminder_at'] = $reminder_at -> format('Y-m-d\TH:i');

                $todoTasksModel = new TaskModel();
                $todoTasksModel -> updateTask($data);

                $tags = explode(',', $_POST['tags']);
                $tags = array_map('trim', $tags);

                $oldtags = $this -> tagsModel -> getTagsByTaskId($data['id']);

                $this -> tagsModel -> removeAllTaskTags($data['id']);

                foreach($tags as $tag_name) {
                    $tag = $this -> tagsModel -> getTagByNameAndUserId($tag_name, $data['user_id']);

                    if(!$tag){
                        $tag_id = $this -> tagsModel -> addTag($tag_name, $data['user_id']);
                    } else {
                        $tag_id = $tag['id'];
                    }
                    $this -> tagsModel -> addTaskTag($data['id'], $tag_id);
                } 
                foreach($oldtags as $oldtag){
                    $this -> tagsModel -> removeUnusedTag($oldtag['id']);
                }

            }
            header("Location: /todo/tasks");
        }

        public function delete($params) {
            $this -> check -> requirePermission();
            $todoCategoryModel = new TaskModel();
            $todoCategoryModel -> deleteTask($params['id']);

            header("Location: /todo/tasks");
        }

        public function updateStatus($params) {
            $this -> check -> requirePermission();

            $datetime = null;
            $status = trim(htmlspecialchars($_POST['status']));

            if($status){
                if($status === 'completed') {
                    $datetime = date("Y-m-d H:i:s");
                }

                $taskModel = new TaskModel();
                $taskModel -> updateTaskStatus($params['id'], $status, $datetime);

                header("Location: /");
            } else {
                echo 'Do not update status';
            }
        }

        public function task($params) {
            $this -> check -> requirePermission();

            $task_id = isset($params['id']) ? intval($params['id']) : 0;
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; 

            $todoTaskModel = new TaskModel();
            $task =  $todoTaskModel -> getTaskByIdAndByIdUser($params['id'], $user_id);

            if(!$task || $task['user_id'] != $user_id) {
                http_response_code(404);
                include 'app/views/errors/404.php';
                return; 
            }

            $todoCategoryModel = new CategoryModel();
            $category = $todoCategoryModel -> CategoryByID($task['category_id']);

            if(!$task) {
                echo "Task not found";
                return;
            }

            $tasks = $this -> tagsModel -> getTagsByTaskId($task['id']); 
            
            include 'app/views/todo/tasks/task.php';  
        }

    }
