<?php 
include "partials/header.php";
include "partials/nav.php";

$error = ""; // Initialize an error message variable

// Check if the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Sanitize and escape user input to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $confirm_password = mysqli_real_escape_string($conn, $_POST["confirm_password"]);  
    
    // Check if passwords match
    if ($password !== $confirm_password){
        $error = "<br>Passwords do not match";
    } else {
        // Check if the username already exists in the database
        $sql = "SELECT * FROM users WHERE username= '$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (!mysqli_num_rows($result) > 0){
            // Hash the password before storing it in the database
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user data into the database
            $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$passwordHash', '$email')";
        
            if(mysqli_query($conn, $sql)){
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $username;
                header("Location: admin.php");
                exit; 
            } else {
                $error = "<br>Failed to insert data: " . mysqli_error($conn);
            }
        } else {
            $error = "<br>Username already exists"; // Error message if username is taken
        } 
    }
}
?>

    
    <div class="container">
        <div class="form-container">
            <!-- Registration form -->
            
            <form method="POST" action="">
                <h2>Create your Account:</h2>
                     <!-- Display error messages, if any -->
                <?php if($error): ?>
                    <p style="color:red"><?php echo $error; ?></p>
                <?php endif; ?>
                <label for="username">Username:</label>
                <!--keep input fields if error occurs so user doesnt have to rewrite: --> 
                <input value="<?php echo isset($username) ? $username : ''; ?>" placeholder="Enter your username" type="text" name="username" required>
             

                <label for="email">Email:</label>
                <input value="<?php echo isset($email) ? $email : ''; ?>" placeholder="Enter your email" type="email" name="email" required>
               

                <label for="password">Password:</label>
                <input placeholder="Enter your password" type="password" name="password" required>
             

                <label for="confirm_password">Confirm Password:</label>
                <input placeholder="Confirm your password" type="password" name="confirm_password" required>
 

                <input type="submit" value="Register">

                
            </form>
        </div>
    </div>
<?php 
    include "partials/footer.php";
 ?>
<?php
mysqli_close($conn);
?>