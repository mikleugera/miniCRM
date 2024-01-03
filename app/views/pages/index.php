<?php 
    $title = 'pages';
    ob_start(); 
?>

<div class="row mt-5">
    <h1 class="text-center mb-4">Pages</h1>
    <a href="/pages/create" class="btn btn-success col-lg-2 mb-4">Create page</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Role</th>
                <th>Created at</th>
                <th>Update at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($pages as $page): ?>
            <tr>
                <td><?= $page['id'] ?></td>
                <td><?= $page['title'] ?></td>
                <td><?= $page['slug'] ?></td>
                <td><?= $page['role'] ?></td>
                <td><?= $page['created_at'] ?></td>
                <td><?= $page['update_at'] ?></td>
                <td>
                    <a href="/pages/edit/<?php echo $page['id']?>" class="btn btn-sm btn-outline-primary">Edit</a>
                    <a href="/pages/delete/<?php echo $page['id']?>" class="btn btn-sm btn-outline-danger">Delete</a>
                </td>
            </tr>
            <? endforeach ?>
        </tbody>
    </table>
</div>

<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>     