<?php 
include 'db.php';

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $confirm_password = mysqli_real_escape_string($conn, $_POST["confirm_password"]);  
    
    if ($password !== $confirm_password){
        $error = "<br>Passwords do not match";
    } else {

        $sql = "SELECT * FROM users WHERE username= '$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (!mysqli_num_rows($result) > 0){

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$passwordHash', '$email')";
        
            if(mysqli_query($conn, $sql)){
            echo "<br>registration complete";
            } else {
                $error = "<br>no data inserted, error: " . mysqli_error($conn);
            }
        } else {
            $error = "<br>username already exists";
        } 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="register">
    <nav>
        <ul>
            <li>
                <a href="index.html">Home</a>
            </li>
    
            <!-- When the user is logged in -->
            <li>
                <a href="admin.html">Admin</a>
            </li>
            <li>
                <a href="logout.html">Logout</a>
            </li>
    
            <!-- When the user is not logged in -->
            <li>
                <a href="register.html">Register</a>
            </li>
            <li>
                <a href="login.html">Login</a>
            </li>
        </ul>
    </nav>
    
<div class="container">
    <div class="form-container">
        <form method="POST" action="">
            <h2>Create your Account</h2>

            <label for="username">Username:</label>
            <input placeholder="Enter your username" type="text" name="username" required>
            <br>
            <label for="email">Email:</label>
            <input placeholder="Enter your email" type="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input placeholder="Enter your password" type="password" name="password" required>
            <br>
            <label for="confirm_password">Confirm Password:</label>
            <input placeholder="Confirm your password" type="password" name="confirm_password" required>
            <br>
            <input type="submit" value="Register">
            <?php if($error): ?>
                <p style="color:red">
                    <?php echo $error; ?>
                </p>
            <?php endif; ?>
        </form>
    </div>
</div>
    
</body>
</html>
