
<nav>  
    <ul> 
       <li><a class="<?php echo setActiveClass('index'); ?>" href="index.php">Home</a></li>
       <?php if(!isUserLoggedIn()): ?>
       <li><a class="<?php echo setActiveClass('register'); ?>" href="register.php">Register</a></li>
        <?php endif; ?>
        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            
            <li><a class="<?php echo setActiveClass('admin'); ?>" href="admin.php">Admin</a></li>
            <li><a href="logout.php">Logout</a></li>
            
        <?php else: ?>
           <li><a class="<?php echo setActiveClass('login'); ?>" href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>