<?php 
    $title = 'Todo list - completed';
    ob_start(); 
?>

<div class="container">
    <h1 class="md-4">Todo List - completed</h1>
    <div class="d-flex justify-content-around row filter-priority">
        <a data-priority="low" class="btn mb-3 col-2 sort-btn" style="background: #51A5F4">Low</a>    
        <a data-priority="medium" class="btn mb-3 col-2 sort-btn" style="background: #3C7AB5">Medium</a>    
        <a data-priority="high" class="btn mb-3 col-2 sort-btn" style="background: #274F75">High</a>    
        <a data-priority="urgent" class="btn mb-3 col-2 sort-btn" style="background: #122436">Urgent</a>    
    </div>
    <div class="accordion" id="tasks-accordion">
        <?php foreach ($completedTasks as &$task): ?>
            <?php
                $priorityColor = '';
                switch($task['priority']){
                    case 'low':
                        $priorityColor = '#51A5F4';
                        break;
                    case 'medium':
                        $priorityColor = '#3C7AB5';
                        break;
                    case 'high':
                        $priorityColor = '#274F75';
                        break;
                    case 'urgent':
                        $priorityColor = '#122436';
                        break;                
                }   
            ?>
            <div class="accordion-item mt-2">
                <div class="accordion-header d-flex justify-content-between aling-items-center row" id="task-<?php echo $task['id']?>">
                    <h2 class="accordion-header">
                        <button style="background: <?=$priorityColor?>" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#task-collapse-<?php echo $task['id']?>" aria-expanded="false" aria-controls="task-collapse-<?php echo $task['id']?>" data-priority="<?php echo $task['priority']?>">
                            <span class="col-12 col-md-6"><i class="fa-solid fa-square-up-right"></i><strong><?php echo $task['title']?></strong></span>
                            <span class="col-6 col-md-3 text-center"><i class="fa-solid fa-person-circle-question"></i><?php echo $task['priority']?></span>
                            <span class="col-6 col-md-3 text-center"><i class="fa-solid fa-hourglass-start"></i><span class="due-date"><?php echo $task['finish_date']?></span></span>
                        </button>
                    </h2>
                </div>
                <div id="task-collapse-<?php echo $task['id']?>" class="accordion-collapse collapse" aria-labelledby="task-<?php echo $task['id']?>" data-bs-parent="#tasks-accordion">
                    <div class="accordion-body">
                    <p class="row">
                            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-layer-group"></i> Category:</strong> <?php echo htmlspecialchars($task['category']['title'] ?? 'N/A')?></span>
                            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-battery-three-quarters"></i> Status:</strong> <?php echo htmlspecialchars($task['status'])?></span>
                        </p>
                        <p class="row">
                            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-person-circle-question"></i> Priority:</strong> <?php echo htmlspecialchars($task['priority'])?></span>
                            <span class="col-12 col-md-6"><strong><i class="fa-solid fa-hourglass-start"></i> Due date:</strong> <?php echo htmlspecialchars($task['finish_date'])?></span>
                        </p>
                        <p>
                            <strong><i class="fa-solid fa-file-prescription"></i> Tags:</strong> 
                            <?php foreach ($task['tags'] as $tag): ?>
                                <a href="/todo/tasks/by-tag/<?= $tag['id']?>" class="tag">
                                    <?= htmlspecialchars($tag['name'])?></a>
                            <?php endforeach?>    
                        </p>
                        <p>
                            <strong><i class="fa-solid fa-file-prescription"></i> Desription:</strong> <?php echo htmlspecialchars($task['description'])?>
                        </p>
                        <div class="d-flex justify-content-start action-task">
                            <a href="/todo/tasks/edit/<?php echo $task['id']?>" class="btn btn-primary me-2">Edit</a>
                            <a href="/todo/tasks/delete/<?php echo $task['id']?>" class="btn btn-danger me-2">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>     