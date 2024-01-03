<?php 
    $title = 'Edit role';
    ob_start(); 
?>

<div class="row justify-content-center mt-5">
  <div class="col-lg-6 col-md-8 col-sm-10">
    <h1 class="text-center mb-4">Edit role</h1>
      <form method="POST" action="/roles/update/<?php echo $role['id'] ?>">
        <input type="hidden" name="id" value="<?= $role['id'] ?>">
        <div class="mb-3">
          <label for="role_name" class="form-label">Name role</label>
          <input type="text" class="form-control" id="role_name" name="role_name" value="<?php echo $role['role_name']?>" required>
        </div>
        <div class="mb-3">
          <label for="role_description" class="form-label">Description role</label>
          <input type="text" class="form-control" id="role_description" name="role_description" value="<?php echo $role['role_description']?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
  </div>  
</div>

<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>     