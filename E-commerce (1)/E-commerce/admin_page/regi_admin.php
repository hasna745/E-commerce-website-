


<?php 
include("../conn/conn.php");

if (isset($_POST['submit'])) {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Check if email and username are unique
    $result = mysqli_query($con, "SELECT * FROM `admins` WHERE email='$email' OR username='$username'");
    if (!$result) {
        echo "Error checking email or username: " . mysqli_error($con);
        exit(); // Stop further execution
    }
    
    $num_rows = mysqli_num_rows($result);
    if ($num_rows > 0) {
        echo '<div id="warning-alert">Email or username already exists.</div>';
        exit(); // Stop further execution
    }
    
    // Insert administrator data into the database
    $sql = "INSERT INTO `admins` (username, password, first_name, last_name, age, email, phone_number, address, city, country) 
            VALUES ('$username', '$hashed_password', '$first_name', '$last_name', '$age', '$email', '$phone_number', '$address', '$city', '$country')";
    
    $result = mysqli_query($con, $sql);
    
    if ($result) {
        echo '<div id="s-alert">Administrator registered successfully!</div>';

         header("Location: index.php");
        exit();
    } else {
        echo "Error inserting data: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Registration</title>
    <style type="text/css">
        form {
    max-width: 500px;
    margin: 50px auto;
    padding: 30px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Labels */
label {
    display: block;
    font-size: 16px;
    margin-bottom: 8px;
    color: #333;
}

/* Text Inputs */
input[type="text"],
input[type="password"],
input[type="number"],
input[type="email"],
input[type="tel"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    color: #555;
}

/* Submit Button */
input[type="submit"] {
    background-color: #4CAF50;
    color: #fff;
    padding: 15px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #45a049;
}
    </style>
<body>
    <h2>Administrator Registration</h2>
    <form action="" method="post">
        <label for="username">Username:</label><br>
        <input type="text" name="username" id="username" required><br>
        
        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required><br>
        
        <label for="first_name">First Name:</label><br>
        <input type="text" name="first_name" id="first_name"><br>
        
        <label for="last_name">Last Name:</label><br>
        <input type="text" name="last_name" id="last_name"><br>
        
        <label for="age">Age:</label><br>
        <input type="number" name="age" id="age"><br>
        
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" required><br>
        
        <label for="phone_number">Phone Number:</label><br>
        <input type="tel" name="phone_number" id="phone_number"><br>
        
        <label for="address">Address:</label><br>
        <input type="text" name="address" id="address"><br>
        
        <label for="city">City:</label><br>
        <input type="text" name="city" id="city"><br>
        
        <label for="country">Country:</label><br>
        <input type="text" name="country" id="country"><br>
        
        <input type="submit" name="submit" value="Register">
    </form>
</body>
</html>
