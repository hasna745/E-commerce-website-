<?php
// Include database connection and start session
include("../conn/conn.php");
session_start();

// Check if the user is logged in
if(!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Retrieve user information
$username = $_SESSION['username'];
$sql = "SELECT * FROM `userinfo` WHERE username='$username'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);

// Check if the delete button is clicked
if(isset($_POST['delete_account'])) {
    // Execute SQL DELETE statement to delete the user's account
    $delete_sql = "DELETE FROM `userinfo` WHERE username='$username'";
    if(mysqli_query($con, $delete_sql)) {
        // Account deleted successfully, redirect to logout page
        header("Location: logout.php");
        exit();
    } else {
        // Error deleting account
        $error_message = "An error occurred while deleting the account.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <!-- Add your CSS styles here -->
</head>
<body>
    <div class="container">
        <h1>Delete Account</h1>
        <p>Are you sure you want to delete your account?</p>
        <?php if(isset($error_message)) { ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php } ?>
        <form action="" method="post">
            <button type="submit" name="delete_account">Yes, Delete My Account</button>
            <a href="profile.php">No, Go Back</a>
        </form>
    </div>
</body>
</html>
