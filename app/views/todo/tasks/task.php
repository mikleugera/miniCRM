<?php 
    $title = 'Todo list';
    ob_start(); 
?>
    <div class="mb-4 card">
        <div class="card-header">
            <h1 class="card-title">
                <i class="fa-solid fa-square-up-right"></i><strong><?php echo $task['title']?></strong>
            </h1>
        </div>
        <div class="card-body">
            <p class="row">
                <span class="col-12 col-md-6"><strong><i class="fa-solid fa-layer-group"></i> Category:</strong> <?php echo htmlspecialchars($category['title'] ?? 'N/A')?></span>
                <span class="col-12 col-md-6"><strong><i class="fa-solid fa-battery-three-quarters"></i> Status:</strong> <?php echo htmlspecialchars($task['status'])?></span>
            </p>
            <p class="row">
                <span class="col-12 col-md-6"><strong><i class="fa-solid fa-person-circle-question"></i> Priority:</strong> <?php echo htmlspecialchars($task['priority'])?></span>
                <span class="col-12 col-md-6"><strong><i class="fa-solid fa-hourglass-start"></i> Start date:</strong> <?php echo htmlspecialchars($task['created_at'])?></span>
            </p>
            <p class="row">
                <span class="col-12 col-md-6"><strong><i class="fa-solid fa-person-circle-question"></i> Update:</strong> <?php echo htmlspecialchars($task['priority'])?></span>
                <span class="col-12 col-md-6"><strong><i class="fa-solid fa-hourglass-start"></i> Due date:</strong> <?php echo htmlspecialchars($task['finish_date'])?></span>
            </p>
            <p>
                <strong><i class="fa-solid fa-file-prescription"></i> Tags:</strong> 
                <?php foreach ($tasks as $tag): ?>
                    <a href="/todo/tasks/by-tag/<?= $tag['id']?>" class="tag">
                        <?= htmlspecialchars($tag['name'])?></a>
                <?php endforeach?>    
            </p>
            <p>
                <strong><i class="fa-solid fa-file-prescription"></i> Desription:</strong> <?php echo htmlspecialchars($task['description'])?>
            </p>
            <div class="d-flex justify-content-start action-task">
                <form action="/todo/tasks/update-status/<?php echo $task['id']?>" method="post" class="me-2">
                    <input type="hidden" name="status" value="cancelled">
                    <button type="sumbit" class="btn <?php echo $task['status'] == 'cancelled' ? 'btn-warning' : 'btn-secondary'?>">
                        Cancelled
                    </button>
                </form>    
                <form action="/todo/tasks/update-status/<?php echo $task['id']?>" method="post" class="me-2">
                    <input type="hidden" name="status" value="new">
                    <button type="sumbit" class="btn <?php echo $task['status'] == 'new' ? 'btn-warning' : 'btn-secondary'?>">
                        New
                    </button>
                </form>    
                <form action="/todo/tasks/update-status/<?php echo $task['id']?>" method="post" class="me-2">
                    <input type="hidden" name="status" value="in_progress">
                    <button type="sumbit" class="btn <?php echo $task['status'] == 'in_progress' ? 'btn-warning' : 'btn-secondary'?>">
                        In progress
                    </button>
                </form>    
                <form action="/todo/tasks/update-status/<?php echo $task['id']?>" method="post" class="me-2">
                    <input type="hidden" name="status" value="on_hold">
                    <button type="sumbit" class="btn <?php echo $task['status'] == 'on_hold' ? 'btn-warning' : 'btn-secondary'?>">
                        On hold
                    </button>
                </form>    
                <form action="/todo/tasks/update-status/<?php echo $task['id']?>" method="post" class="me-2">
                    <input type="hidden" name="status" value="completed">
                    <button type="sumbit" class="btn <?php echo $task['status'] == 'completed' ? 'btn-warning' : 'btn-secondary'?>">
                        Completed
                    </button>
                </form>    
                <a href="/todo/tasks/edit/<?php echo $task['id']?>" class="btn btn-primary me-2">Edit</a>
                <a href="/todo/tasks/delete/<?php echo $task['id']?>" class="btn btn-danger me-2">Delete</a>
            </div>
        </div>
        </div>
    </div>

<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>     
