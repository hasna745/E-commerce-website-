<?php
// Démarrer la session
session_start();

// Inclure le fichier de connexion à la base de données
include("../conn/conn.php");

// Vérifier si la session contient le nom d'utilisateur de l'administrateur
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
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
</head>
<body>
    <ul>
        <li><a href="">Home</a></li>
    </ul>

    <div class="bg-light">
        <h3 class="text-center p-2">Manage data </h3>
    </div>
    <ul>
        <li><a href="index.php?insert_pr">insert categories</a></li>
        <li><a href="view_cate.php">view categories</a></li>
        <li><a href="insert_prod.php">insert product</a></li>
        <li><a href="index.php?view_products">view products</a></li>
        <li><a href="order.php">view orders</a></li>
        <li><a href="index.php?view_users">liste of users</a></li>
        <li><a><?php echo $username; ?></a></li>
        <li><a href="logout.php">Logout</a></li>
        <li><a href="regi_admin.php">register</a></li>
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
            // Your insertion logic here
        }
        ?>
    </div>

    <footer>
        <p>Created by estitica-casa</p>
    </footer>
</body>
</html>

<?php  
include('../conn/conn.php');

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


} else {
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
</head>
<body>
    <div class="bg-light">
        <h3 class="text-center p-2">Manage data </h3>
    </div>
    <ul>
        <li><a href="#">insert categories</a></li>
        <li><a href="#">view categories</a></li>
        <li><a href="#">insert product</a></li>
        <li><a href="#">view products</a></li>
        <li><a href="#">liste of users</a></li>
        <li><a href="logi_adm.php">login</a></li>
        <li><a href="">Logout</a></li>
        <li><a href="regi_admin.php">register</a></li>
    </ul>
</body>
</html>
<?php
}
?>
