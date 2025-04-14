<?php 
include 'db.php'; // Include database connection
session_start();

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to external stylesheet -->
</head>

<body class="register">
    <!-- Navigation menu -->
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>

            <!-- When the user is logged in -->
            <li><a href="admin.html">Admin</a></li>
            <li><a href="logout.html">Logout</a></li>

            <!-- When the user is not logged in -->
            <li><a href="register.html">Register</a></li>
            <li><a href="login.html">Login</a></li>
        </ul>
    </nav>
    
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
</body>
</html>
<?php
mysqli_close($conn);
?>