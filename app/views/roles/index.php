<?php 
    $title = 'Roles';
    ob_start(); 
?>

<div class="row justify-content-center mt-5">
  <div class="col-lg-6 col-md-8 col-sm-10">
    <h1 class="text-center mb-4">Roles</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name role</th>
                    <th>Description role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($roles as $role): ?>
                <tr>
                    <td><?= $role['id'] ?></td>
                    <td><?= $role['role_name'] ?></td>
                    <td><?= $role['role_description'] ?></td>
                    <td>
                        <a href="/roles/edit/<?php echo $role['id']?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="/roles/delete/<?php echo $role['id']?>" class="btn btn-sm btn-outline-danger">Delete</a>
                    </td>
                </tr>
                <? endforeach ?>
            </tbody>
        </table>
  </div>  
</div>

<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>     