<?php 
include("../conn/conn.php");
session_start();

// Récupérer les informations de l'utilisateur depuis la base de données
$username = $_SESSION['username'];
$sql = "SELECT * FROM `userinfo` WHERE username='$username'";
$result = mysqli_query($con, $sql);

// Vérifier si des données ont été récupérées
if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);

    // Fonction pour mettre à jour les informations de l'utilisateur
    function updateUserInfo($con, $username, $prenom, $nom, $email, $age, $adresse) {
        // Préparer la requête SQL pour mettre à jour les informations de l'utilisateur
        $sql = "UPDATE `userinfo` SET prenom='$prenom', nom='$nom', email='$email', age='$age', adresse='$adresse' WHERE username='$username'";
        // Exécuter la requête SQL
        if (mysqli_query($con, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    // Vérifier si le formulaire de modification a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $adresse = $_POST['adresse'];
        // Mettre à jour les informations de l'utilisateur
        if (updateUserInfo($con, $username, $prenom, $nom, $email, $age, $adresse)) {
            // Afficher un message de succès
            $success_message = "Les données ont été modifiées avec succès.";
            // Rediriger vers la page de profil
            header("Location: profile.php");
            exit;
        } else {
            // Afficher un message d'erreur en cas d'échec de la mise à jour
            $error_message = "Erreur lors de la mise à jour des informations.";
        }
    }
} else {
    // Afficher un message d'erreur si aucune donnée n'est récupérée
    $error_message = "Aucune donnée d'utilisateur trouvée.";
}
?>


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
        .user-image {
            margin-bottom: 20px;
        }
        .user-image img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form {
            margin-bottom: 20px;
        }
        .profile-info {
            text-align: left;
            margin-bottom: 20px;
        }
        .profile-info label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .profile-info input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .button-container a {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .button-container a:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Profil</h1>
        <?php if(isset($row)) { ?>
        <div class="user-image">
            <img src="../images/user_images/<?php echo $row['image_path']; ?>" alt="Image de l'utilisateur">
        </div>
        <form action="" method="post">
            <div class="profile-info">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo $row['prenom']; ?>"><br>
                
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?php echo $row['nom']; ?>"><br>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>"><br>
                
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo $row['age']; ?>"><br>
                
                <label for="adresse">Adresse:</label>
                <input type="text" id="adresse" name="adresse" value="<?php echo $row['adresse']; ?>"><br>
            </div>
            <?php if(isset($error_message)) { ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php } ?>
            <div  class="button-container">
            <input  type="submit" value="Modifier"></div>
        </form>
        <?php } else { ?>
            <p>Aucune donnée d'utilisateur trouvée.</p>
        <?php } ?>
        <div class="button-container">
            <a href="../home.php">Retour à la page d'accueil</a>
        </div>
    </div>
</body>
</html>
