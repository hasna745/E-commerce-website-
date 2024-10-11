

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

// Suppression de la catégorie
if(isset($_GET['delete_category'])) {
    $id_category_to_delete = $_GET['delete_category'];
    $delete_query = "DELETE FROM `Categories` WHERE id_cat = $id_category_to_delete";
    mysqli_query($con, $delete_query);
}

// Récupération de toutes les catégories
$select_categories = "SELECT * FROM `Categories`";
$result_categories = mysqli_query($con, $select_categories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../CSS/css.css">
    <link rel="stylesheet" type="text/css" href="../CSS/css-img.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

     <style>
        /* Table styles */
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th,
        .table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .table th {
            background-color: #f2f2f2;
        }
        /* Image styles */
        .image img {
            max-width: 100px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        /* Centering text in the last column */
        .table td:last-child {
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="bg-light">
        <h3 class="text-center p-2">Manage data </h3>
    </div>
    <ul>
        <li><a href="index.php?insert_pr">insert categories</a></li>
        <li><a href="view_cate.php">view categories</a></li>
        <li><a href="insert_prod.php">insert product</a></li>
        <li><a href="index.php?view_products">view products</a></li>
        <li><a href="index.php?view_users">liste of users</a></li>
        <li><a href="order.php">view orders</a></li>
        <li><a><?php echo $username; ?></a></li>
        <li><a href="logout.php">Logout</a></li>
        <li><a href="regi_admin.php">register</a></li>


    </ul>


<h2>Manage Categories</h2>

<div class="container">
    <div class="row">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result_categories)) { ?>
                    <tr>
                        <td><?php echo $row['id_cat']; ?></td>
                        <td><?php echo $row['nom_cat']; ?></td>
                        <td>
                            <a href="edit_category.php?id=<?php echo $row['id_cat']; ?>">Edit</a>
                            <a href="?delete_category=<?php echo $row['id_cat']; ?>" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<footer>
    <p>Created by estitica-casa</p>
</footer>

</body>
</html>
