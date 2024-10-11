<?php
include("../conn/conn.php");

if(isset($_POST['insert_category'])) {
    $category_name = mysqli_real_escape_string($con, $_POST['category_name']);
    $insert_query = "INSERT INTO `Categories` (nom_cat) VALUES ('$category_name')";
    mysqli_query($con, $insert_query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
</head>
<body>
    <h2>Add Category</h2>
    <form action="" method="post">
        <label for="category_name">Category Name:</label><br>
        <input type="text" id="category_name" name="category_name"><br>
        <input type="submit" name="insert_category" value="Add Category">
    </form>
</body>
</html>
