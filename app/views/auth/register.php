<?php 
    $title = 'Register';
    ob_start(); 
?>

<div class="row justify-content-center mt-5">
  <div class="col-lg-6 col-md-8 col-sm-10">
    <h1 class="text-center mb-4">Register</h1>
    <form method="POST" action="/auth/store">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="text" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <div class="mt-4">
      <p>Already have an account? <a href="/auth/login"><?= htmlspecialchars("Login here")?></a></p>  
    </div>
  </div>
</div>

<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>     