<?php 
    $title = 'Edit Task';
    ob_start(); 
?>

<h1 class="mb-4">Edit Task</h1>
<form action="/todo/tasks/update" method="post">
  <input type="hidden" name="id" value="<?= $task['id']?>">
    <div class="row">
        <div class="col-12 col-md-6 mb-3">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($task['title'])?>" required>
        </div>  

        <div class="col-12 col-md-6 mb-3">
            <label for="reminder_at">Reminder At</label>
            <select class="form-control" id="reminder_at" name="reminder_at">
                <option value="30_minutes">30 хвилин</option>
                <option value="1_hour">1 година</option>
                <option value="2_hours">2 години</option>
                <option value="12_hours">12 годин</option>
                <option value="24_hours">24 години</option>
                <option value="7_days">7 днів</option>
            </select>
        </div>  

        <div class="col-12 col-md-6 mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id']?>" <?= $category['id'] == $task['category_id'] ? 'selected' : ''?>> <?= $category['title']?></option>
                    <? endforeach ?>    
                </select>    
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label for="finish_date">Finish Date</label>
            <input type="datetime-local" class="form-control" id="finish_date" name="finish_date" value="<?= $task['finish_date'] !== null ? htmlspecialchars(str_replace('', 'T', $task['finish_date'])) : ''?>" required>
        </div>  

        <div class="col-12 col-md-6 mb-3">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="new" <?= $task['status'] == 'new' ? 'selected' : ''?>>New</option>
                <option value="in_progress" <?= $task['status'] == 'in_progress' ? 'selected' : ''?>>In progress</option>
                <option value="completed" <?= $task['status'] == 'completed' ? 'selected' : ''?>>Completed</option>
                <option value="on_hold" <?= $task['status'] == 'on_hold' ? 'selected' : ''?>>On hold</option>
                <option value="cancelled" <?= $task['status'] == 'cancelled' ? 'selected' : ''?>>Cancelled</option>
            </select>
        </div>  

        <div class="col-12 col-md-6 mb-3">
            <label for="priority">Priority</label>
            <select class="form-control" id="priority" name="priority">
                <option value="low" <?= $task['priority'] == 'low' ? 'selected' : ''?>>Low</option>
                <option value="medium" <?= $task['priority'] == 'medium' ? 'selected' : ''?>>Medium</option>
                <option value="high" <?= $task['priority'] == 'high' ? 'selected' : ''?>>High</option>
                <option value="urgent" <?= $task['priority'] == 'urgent' ? 'selected' : ''?>>Urgent</option>
            </select>
        </div>  
    </div>
    <div class="row">
        <div class="col-12 col-md-6 mb-3">
            <label for="tags">Tags</label>
            <div class="tags-container form-control">
                <?php 
                    $tagNames = array_map(function ($tags) {
                        return $tags['name'];
                    }, $tags);
                    foreach($tagNames as $tagName) {
                        echo "<div class='tag'>
                                    <span>$tagName</span>
                                    <button type='button'>x</button>
                                </div>";
                            }
                ?>
                <input type="text" class="form-control" id="tag-input">
            </div>
            <input type="hidden" class="form-control" id="hidden-tags" name="tags" value="<?= htmlspecialchars(implode(', ', $tagNames))?>">
        </div>  
        
        <div class="col-12 col-md-6 mb-3">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($task['description'] ?? '')?></textarea>
        </div>  
    </div>
    
    <div class="row">
        <div class="col-12">     
            <button type="submit" class="btn btn-primary">Update Task</button>
        </div>
    </div>
</form>

<script>
    const tagInput = document.querySelector('#tag-input');
    const tagsContainer = document.querySelector('.tags-container');
    const hiddenTags = document.querySelector('#hidden-tags');
    const existingTags = '<?= htmlspecialchars(isset($task['tags']) ? $task['tags'] : '') ?>';

    function createTag(text) {
        const tag = document.createElement('div');
        tag.classList.add('tag');
        const tagText = document.createElement('span');
        tagText.textContent = text;

        const closeButton = document.createElement('button');
        closeButton.innerHTML = '&times;';
        
        closeButton.addEventListener('click', () => {
            tagsContainer.removeChild(tag);
            updateHiddenTags();
        });

        tag.appendChild(tagText);
        tag.appendChild(closeButton);

        return tag;
    }

    function updateHiddenTags() {
        const tags = tagsContainer.querySelectorAll('.tag span');      
        const tagText = Array.from(tags).map(tag => tag.textContent);
        hiddenTags.value = tagText.join(','); 
    } 

    tagInput.addEventListener('input', (e) => {
        if(e.target.value.includes(',')){
            const tagText = e.target.value.slice(0, -1).trim();
            // if(tagText.lenght > 0) {
                const tag = createTag(tagText);
                tagsContainer.insertBefore(tag, tagInput);
                updateHiddenTags();
            // }
            e.target.value = '';      
        }
    });

    tagsContainer.querySelectorAll('.tag button').forEach(button => {
        button.addEventListener('click', () => {
            tagsContainer.removeChild(button.parentElement);
            updateHiddenTags();
        });
    });
                            
</script>
<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>     