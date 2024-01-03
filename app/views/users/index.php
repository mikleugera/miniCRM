<?php 
    $title = 'User list';
    ob_start(); 
?>

    <h1>User list</h1>

    <a href="/users/create" class="btn btn-success">Create user</a>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Email verification</th>
            <th scope="col">Is admin</th>
            <th scope="col">Role</th>
            <th scope="col">Is active</th>
            <th scope="col">Last login</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($users as $user): ?>
            <tr>
                <th scope="row"><?php echo $user['id']?></th>
                <td><?php echo $user['username']?></td>
                <td><?php echo $user['email']?></td>
                <td><?php echo $user['email_verification'] ? 'yes' : 'no'?></td>
                <td><?php echo $user['is_admin'] ? 'yes' : 'no'?></td>
                <td><?php echo $user['role']?></td>
                <td><?php echo $user['is_active'] ? 'yes' : 'no'?></td>
                <td><?php echo $user['last_login']?></td>
                <td>
                    <a href="/users/edit/<?php echo $user['id']?>" class="btn btn-primary">Edit</a>
                    <a href="/users/delete/<?php echo $user['id']?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>   
        <?php endforeach?>    
        </tbody>
    </table>
<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>      


