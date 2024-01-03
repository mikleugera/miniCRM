<?php $user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'no name'?>
<?php $user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'no role'?>
<!DOCTYPE html>
<html >
  <head>
    <title><?= $title?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/app/css/style.css">
    <script src="https://kit.fontawesome.com/4541a3e9d7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="sidebar col-md-3">
                <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="min-height: 900px;">
                    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <svg class="bi me-2" width="40" height="32"><use xlink:href="/"></use></svg>
                        <span class="fs-4">Mini CRM</span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <?php if($user_role == 5 || !ENABLE_PERMISSION_CHECK): ?>
                            <li class="nav-item">
                                <a href="/users" class="nav-link text-white">Users</a>
                            </li>
                            <li class="nav-item">
                                <a href="/roles" class="nav-link text-white">All Roles</a>
                            </li>
                            <li class="nav-item">
                                <a href="/roles/create" class="nav-link text-white">Create role</a>
                            </li>
                            <li class="nav-item">
                                <a href="/pages" class="nav-link text-white">Pages</a>
                            </li>
                            <hr>
                        <?php endif ?>   
                        <h4>To do list</h4>
                        <li class="nav-item">
                            <a href="/todo/tasks" class="nav-link text-white">Tasks (opened)</a>
                        </li>
                        <li class="nav-item">
                            <a href="/todo/tasks/completed" class="nav-link text-white">Tasks (completed)</a>
                        </li>
                        <li class="nav-item">
                            <a href="/todo/tasks/expired" class="nav-link text-white">Tasks (expired)</a>
                        </li>
                        <li class="nav-item">
                            <a href="/todo/tasks/create" class="nav-link text-white">Create task</a>
                        </li>
                        <li class="nav-item">
                            <a href="/todo/category" class="nav-link text-white">Category</a>
                        </li> 
                    </ul>
                    <hr>
                    <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                        <strong><?= $user_email?></strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="/users/profile">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/auth/logout">Sign out</a></li>
                        <li><a class="dropdown-item" href="/auth/login">Sign in</a></li>
                    </ul>
                    </div>
                </div>
            </div>
            <div class="article col-md-9">
                <div class="container mt-4">
                    <?php echo $content?>
                </div>
            </div>
        </div>
    </div>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/app/js/my.js"></script>
  </body>
</html>