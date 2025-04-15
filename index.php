<?php 
    include "partials/header.php"; 
    include "partials/nav.php"; 
?>

<div class="container">

    <div class="hero">

        <div class="hero-content">
            <h1>Welcome to our PHP login app</h1>
            <p>Securely login and manage your account</p>
            <div class="hero-buttons">
            <?php if (!isUserLoggedIn()):?>
              <a class="btn" href="login.php">Login</a>
              <a class="btn" href="register.php">Register</a>  
            
            <?php endif; ?>
            </div>
        </div>
    </div>
    
  
</div>
<?php include "partials/footer.php"; ?>