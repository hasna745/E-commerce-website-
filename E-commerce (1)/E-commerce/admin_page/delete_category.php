<?php
// Démarrer la session
session_start();

// Inclure le fichier de connexion à la base de données
include("../conn/conn.php");

// Vérifier si la session contient le nom d'utilisateur de l'administrateur
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
} else {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit(); // Arrêter l'exécution du script
}
?>


<?php
include("../conn/conn.php");

if(isset($_GET['id'])) {
    $category_id = $_GET['id'];
    $delete_query = "DELETE FROM `Categories` WHERE id_cat = $category_id";
    mysqli_query($con, $delete_query);
     header("Location: view_cate.php");
        exit();
    
}
?>
