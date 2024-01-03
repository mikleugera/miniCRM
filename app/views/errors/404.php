<?php 
    $title = '404 not found';
    ob_start(); 
?>

<h1>404</h1>
<h2>Not Found</h2>
<p>The page you are looking for could not be found</p>

<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>     