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
    header("Location: logi_adm.php");
    exit(); // Arrêter l'exécution du script
}
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


<style type="text/css">
    


    table {
    width: 100%;
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
}

th, td {
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}

</style>
</head>
<body>

    <div class="bg-light">
        <h3 class="text-center p-2"><b>Manage data </b></h3>
    </div>
    <ul>
        <li><a href="index.php?insert_pr">insert categories</a></li>
        <li><a href="view_cate.php">view categories</a></li>
        <li><a href="insert_prod.php">insert product</a></li>
        <li><a href="index.php?view_products">view products</a></li>
        <li><a href="index.php?view_users">liste of users</a></li>
       
        

        
        <li><a><?php echo $username; ?></a></li>
   
 <li><li><a href="logout.php">Logout</a></li>
</li>
<li><li><a href="regi_admin.php">register</a></li>

    </ul>
    <div class="container my-5">
        <?php
        if(isset($_GET['insert_pr'])){
            include('insert_cat.php');
        }

        if(isset($_GET['view_products'])){
            include('view_product.php');
        }

        if(isset($_GET['view_users'])){
            include('view_user.php');
        }

        if(isset($_POST['insert_Categories'])) {
    
    if(!empty($ins_cate)) {
        $sql = "INSERT INTO `categories` (nom_cat) VALUES ('$ins_cate')";
        $result = mysqli_query($con, $sql);
        
        if($result) {
            $sql1 = "SELECT * FROM `categories` WHERE nom_cat='$ins_cate'";
            $result1 = mysqli_query($con, $sql1);
            
            if($result1) {
                $num = mysqli_num_rows($result1);
                
                if($num <= 1) {
                    echo "<script> alert('Category has been inserted successfully');</script>";
                } else {
                    echo "<script> alert('Category already exists');</script>";
                }
            } else {
                echo "<script> alert('Error: ". mysqli_error($con) ."');</script>";
            }
        } else {
            echo "<script> alert('Error inserting category: ". mysqli_error($con) ."');</script>";
        }
    } else {
        echo "<script> alert('Please set a category name');</script>";
    }
} 
?>
    <h1>Liste des commandes</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>procuts</th>
                <th>Quantities</th>
                <th>price </th>
                <th>total price</th>
                <th>user name</th>
                <th>Date of commande</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Sélectionnez les données de la table "orders" avec une quantité différente de zéro et regroupez par produit
            $query = "SELECT product_name,quantity AS total_quantity, unit_price, total_price, username, order_date FROM orders WHERE quantity > 0 GROUP BY product_name";
            $result = mysqli_query($con, $query);

            // Vérifiez s'il y a des données
            if(mysqli_num_rows($result) > 0) {
                // Parcours chaque ligne de résultat
                while($row = mysqli_fetch_assoc($result)) {
                    // Affichez les données dans le tableau HTML
                    echo "<tr>";
                    echo "<td>#</td>";
                    echo "<td>" . $row['product_name'] . "</td>";
                    echo "<td>" . $row['total_quantity'] . "</td>";
                    echo "<td>" . $row['unit_price'] . "</td>";
                    echo "<td>" . $row['total_price'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['order_date'] . "</td>";
                    echo "</tr>";
                }
            } else {
                // Affichez un message si aucune commande n'a été trouvée
                echo "<tr><td colspan='7'>Aucune commande trouvée.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>

    <footer>
        <p>Created by estitica-casa</p>
    </footer>
</body>
</html>
