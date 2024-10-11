<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        form {
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Login</h2>

    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>

 <?php
// Inclure le fichier de connexion à la base de données
include("../conn/conn.php");

// Vérifier si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer le nom d'utilisateur depuis le formulaire
    $username = $_POST["username"];

    // Requête SQL pour vérifier si l'utilisateur existe dans la base de données
    $query = "SELECT * FROM `admins` WHERE username = '$username'";

    // Exécuter la requête
    $result = mysqli_query($con, $query);

    // Vérifier s'il y a des résultats
    if (mysqli_num_rows($result) > 0) {
        // L'utilisateur existe dans la base de données
        // Commencer la session
        session_start();
        // Stocker le nom d'utilisateur dans la session
        $_SESSION["username"] = $username;
        // Rediriger vers la page d'accueil ou une autre page
        header("Location: index.php");
        exit();
    } else {
        // L'utilisateur n'existe pas dans la base de données
        echo "L'utilisateur n'existe pas dans la base de données.";
    }
}
?>


</body>
</html>
