<?php 
    $title = 'Create task';
    ob_start(); 
?>

<div class="row justify-content-center mt-5">
  <div class="col-sm-10">
    <h1 class="text-center mb-4">Create task</h1>
      <form method="POST" action="/todo/tasks/store">
      <div class="row">
        <div class="mb-3 col-12 col-md-12">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 col-12 col-md-6">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id']?>"><?= $category['title']?></option>
                <? endforeach ?>    
            </select>    
        </div>
        <div class="mb-3 col-12 col-md-6">
            <label for="finish_date" class="form-label">Finish_date</label>
            <input type="text" class="form-control" id="finish_date" name="finish_date" required>          
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Create task</button>
      </form>
  </div>
</div>    

<script>
 document.addEventListener('DOMContentLoaded', () => {
    flatpickr('#finish_date'), {
      enableTime: true,
      noCalendar: false,
      dateFormat: "Y-m-d H:00:00",
      time_24hr: true,
      minuteIncrement: 60
    };    
 }); 
</script> 
<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>     