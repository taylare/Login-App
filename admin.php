<?php 
    include "partials/header.php";
    include "partials/nav.php";

    if (!isUserLoggedIn()) {
        redirect("login.php");
    }

    // Editing user emails:
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["edit_user"])) {
            $user_id = mysqli_real_escape_string($conn, $_POST["user_id"]);
            $new_email = mysqli_real_escape_string($conn, $_POST["email"]);
            $new_username = mysqli_real_escape_string($conn, $_POST["username"]); 

            $sql = "UPDATE users SET email = '$new_email', username = '$new_username' WHERE id = $user_id";
            $result = mysqli_query($conn, $sql);
           
           //notification
            $query_status = check_query($result);
            
            if ($query_status === true) {

                $_SESSION['message'] = "user updated successfully to {$new_username}, {$new_email}";
                $_SESSION['msg_type'] = "success";


                redirect("admin.php");
            }
        } 
        elseif (isset($_POST["delete_user"])) { // Deleting users:
            $user_id = mysqli_real_escape_string($conn, $_POST["user_id"]); 

            $sql = "DELETE FROM users WHERE id = $user_id";
            $result = mysqli_query($conn, $sql);
            //notification
            $query_status = check_query($result);
            
            if ($query_status === true) {

                $_SESSION['message'] = "user deleted successfully, record with id: {$user_id}";
                $_SESSION['msg_type'] = "error";

                redirect("admin.php");
            }
        }
    }

    //  fetch the updated list:
    $result = mysqli_query($conn, "SELECT id, username, email, reg_date FROM users;");
?>

    <h1> Welcome to admin <?php echo $_SESSION['username'] ?>!</h1>
    <h1>Manage Users</h1>

<div class="container">

    <?php if (isset($_SESSION['message'])): ?> <!--checking whether a message exists in the session before showing it -->

        <div class="notification <?php echo $_SESSION['msg_type']?>">
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['msg_type']);
            ?>
        </div>


     <?php endif; ?>   
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
                    <input type="text" name="username" value="<?php echo $user['username'] ?>" required>
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