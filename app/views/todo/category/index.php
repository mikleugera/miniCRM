<?php 
    $title = 'Categories';
    ob_start(); 
?>

<div class="row justify-content-center mt-5">
  <div>
    <h1 class="text-center mb-4">Categories</h1>
    <a href="/todo/category/create" class="btn btn-success mb-4">Create category</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Usability</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $category): ?>
                <tr>
                    <td><?= $category['id'] ?></td>
                    <td><?= $category['title'] ?></td>
                    <td><?= $category['description'] ?></td>
                    <td><?= $category['usability'] ?></td>
                    <td>
                        <a href="/todo/category/edit/<?php echo $category['id']?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="/todo/category/delete/<?php echo $category['id']?>" class="btn btn-sm btn-outline-danger">Delete</a>
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