
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="styles.css"> <!-- Inclure le fichier CSS pour le style -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
        }
        .profile-info {
            margin-top: 20px;
            text-align: left;
        }
        .profile-info label {
            font-weight: bold;
        }
        .profile-info p {
            margin: 5px 0;
        }
        .profile-info p span {
            font-weight: normal;
        }
        .user-image {
            margin-top: 20px;
        }
        .user-image img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .button-containera {
    display: flex;
    justify-content: center; /* Center items horizontally */
    list-style: none;
    padding: 0;
}

.button-containera li {
    margin-right: 10px; /* Adjust the spacing between buttons */
}

.button-containera li:last-child {
    margin-right: 0; /* Remove margin from the last button */
}

.button-containera a {
    padding: 8px 16px; /* Adjust button padding */
    background-color: #4caf50;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.button-container a:hover {
    background-color: #45a049;
}

.button-container {
    text-align: center; /* Center the buttons horizontally */
}

.button-container a {
    display: inline-block; /* Display buttons as inline-block elements */
    margin: 0 10px; /* Adjust the spacing between buttons */
    padding: 10px 20px; /* Adjust button padding */
    background-color: #4caf50;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.button-container a:hover {
    background-color: #45a049;
}



    </style>
</head>
<body>
    <?php 
include("../conn/conn.php");
session_start();

$sql = "SELECT * FROM `userinfo` WHERE username = '".$_SESSION['username']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
?>

<div class="container">
    <div class="button-containera">
        
        <?php if(!isset($_SESSION['username'])): ?>
      <li>
        <a href="#">Welcome Guest</a>
      </li>
      <?php else: ?>
      <li >
        <a  href="users/profile.php" style="display: inline-block; background-color: black; color: white; text-decoration: none; padding: 10px 20px; margin: 10px; border-radius: 5px;">Welcome <?php echo $_SESSION['username']; ?></a>
      </li>
      <?php endif; ?>
      <?php if(!isset($_SESSION['username'])): ?>
      <li >
        <a  href="login.php" style="display: inline-block; background-color: black; color: white; text-decoration: none; padding: 10px 20px; margin: 10px; border-radius: 5px;">Login</a>
      </li>
      <?php else: ?>
      <li >
        <a  href="logout.php" style="display: inline-block; background-color: black; color: white; text-decoration: none; padding: 10px 20px; margin: 10px; border-radius: 5px;">Logout</a>
      </li>
      <?php endif; ?>
    </ul>
  </div>
    <div class="user-image">
        <img src="../images/user_images/<?php echo $row['image_path']; ?>" alt="Image de profil">
    </div>
   <div class="profile-info">
    <label for="username">Username:</label>
    <p><span><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ""; ?></span></p>
    <label for="fullname">Full name:</label>
    <p><span><?php echo isset($row['prenom']) && isset($row['nom']) ? $row['prenom']." ".$row['nom'] : ""; ?></span></p>
    <label for="email">Email:</label>
    <p><span><?php echo isset($row['email']) ? $row['email'] : ""; ?></span></p>
    <label for="birthdate">Age:</label>
    <p><span><?php echo isset($row['age']) ? $row['age'] : ""; ?></span></p>
    <label for="location">Localisation:</label>
    <p><span><?php echo isset($row['adresse']) ? $row['adresse'] : ""; ?></span></p>
</div>




<div class="button-container">
      <a href="update_page.php" style="display: inline-block; background-color: black; color: white; text-decoration: none; padding: 10px 20px; margin: 10px; border-radius: 5px;">edit profil</a>  
        <a href="../home.php" style="display: inline-block; background-color: black; color: white; text-decoration: none; padding: 10px 20px; margin: 10px; border-radius: 5px;">back home</a>
        <a href="delet_acount.php"style="display: inline-block; background-color: black; color: white; text-decoration: none; padding: 10px 20px; margin: 10px; border-radius: 5px;" >delete account</a>
     
  </div>


</body>
</html>
