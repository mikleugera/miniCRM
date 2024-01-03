<?php 
    $title = 'Create category';
    ob_start(); 
?>

<div class="row justify-content-center mt-5">
  <div class="col-sm-10">
    <h1 class="text-center mb-4">Create category</h1>
      <form method="POST" action="/todo/category/store">
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea type="text" class="form-control" id="description" name="description" rows="3" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Create category</button>
      </form>
  </div>
</div>    


<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>     