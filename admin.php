<?php 
    include "partials/header.php";
    include "partials/nav.php";

    if (!isUserLoggedIn()) {
        redirect("login.php");
    }

    $result = mysqli_query($conn, "SELECT id, username, email, reg_date FROM users;");
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["edit_user"])) { //check if edit is clicked
            $user_id = mysqli_real_escape_string($conn, $_POST["user_id"]);
            $new_email = mysqli_real_escape_string($conn, $_POST["email"]); 

            $sql = "UPDATE users SET email = '$new_email' WHERE id = $user_id";
            mysqli_query($conn, $sql);
            redirect("admin.php");
        }
    }
 
 ?>

    <h1> Welcome to admin <?php echo $_SESSION['username'] ?>!</h1>
    <h1>Manage Users</h1>

<div class="container">
    <table class="user-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Registration Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        
        <?php while ($user = mysqli_fetch_assoc($result)): ?>
        <tr> 
        <td><?php echo $user['id']?></td>
        <td><?php echo $user['username']?></td>
        <td><?php echo $user['email']?></td>
        <td><?php echo readableDate($user['reg_date']) ?></td>
        <td><form method="POST" style="display:inline-block;">
                    <input type="hidden" name="user_id" value="<?php echo $user['id'] ?>">
                    <input type="email" name="email" value="<?php echo $user['email'] ?>" required>
                    <button class="edit" type="submit" name="edit_user">Edit</button>
                </form>
                <form method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                    <input type="hidden" name="user_id" value="<?php echo $user['id'] ?>">
                    <button class="delete" type="submit" name="delete_user">Delete</button>
                </form></td>

             




            </td>
        </tr>
         <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php 
    include "partials/footer.php";
 ?>