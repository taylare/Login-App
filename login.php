<?php 


include "partials/header.php";
include "partials/nav.php";
 

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
    header("Location: admin.php");
} //keeps you logged in


$error = ""; // Initialize an error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result); //key for column name
        
        if (password_verify($password, $user['password'])) {
        
           $_SESSION['logged_in'] = true;
           $_SESSION['username'] = $user['username'];
           header("Location: admin.php");
           exit; 

        } else {
            $error = "<br> username or pw incorrect";
        }

    } else {
        $error = "User not found";
    }
}

?>

    
    <div class="container">
        <div class="form-container">
            <!-- login form -->
            <form method="POST" action="">
                <h2>Login</h2>

                <label for="username">Username:</label>
                <input placeholder="Enter your username" type="text" name="username" required>
                <br>
                <br>

                <label for="password">Password:</label>
                <input placeholder="Enter your password" type="password" name="password" required>
                <br>


                <input type="submit" value="Login">

                <!-- Display error messages, if any -->
                <?php if($error): ?>
                    <p style="color:red"><?php echo $error; ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>
<?php 
    include "partials/footer.php";
 ?>
<?php
mysqli_close($conn);
?>