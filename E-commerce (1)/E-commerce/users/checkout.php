<?php 
session_start(); // Start the session

// Establish database connection
$con = mysqli_connect('localhost', 'root', '', 'ecomerce');

// Check connection
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Récupération des catégories
$categories_query = "SELECT * FROM `categories`";
$categories_result = mysqli_query($con, $categories_query);

// Récupération des produits
$products_query = "SELECT * FROM `product_table` ORDER BY RAND() LIMIT 0, 20";
$products_result = mysqli_query($con, $products_query);

function getIPAddress() {  
    //whether ip is from the share internet  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
    //whether ip is from the remote address  
    else{  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
}  

function cart() {
    if(isset($_GET['add-to-cart'])) {
        global $con;
        $get_pro_id = $_GET['add-to-cart'];
        $f1 = getIPAddress();
        $queryy = "SELECT * FROM `cart_detailles` WHERE ip_adresse='$f1' AND id_prod='$get_pro_id'";
        $result = mysqli_query($con, $queryy);
        $num_row = mysqli_num_rows($result);
        if($num_row > 0) {
            echo "<script>alert('This item is already present inside cart');</script>";
            echo "<script>window.open('home.php','_self');</script>";
        } else {
            $queryy = "INSERT INTO `cart_detailles` (id_prod, ip_adresse, quantite_cho) VALUES ('$get_pro_id', '$f1', 0)";
            $result1 = mysqli_query($con, $queryy);
            if($result1) {
                echo "<script>alert('Item successfully added to cart');</script>";
                echo "<script>window.open('home.php','_self');</script>";
            } else {
                echo "<script>alert('Failed to add item to cart');</script>";
                echo "<script>window.open('home.php','_self');</script>";
            }
        }
    }
}

function contenue_cart(){
    if(isset($_GET['add-to-cart'])) {
        global $con;
        $f1 = getIPAddress();
        $queryy = "SELECT * FROM `cart_detailles` WHERE ip_adresse='$f1'";
        $result = mysqli_query($con, $queryy);
        $num_prod_in_cart = mysqli_num_rows($result);
    } else {
        global $con;
        $f1 = getIPAddress();
        $queryy = "SELECT * FROM `cart_detailles` WHERE ip_adresse='$f1'";
        $result = mysqli_query($con, $queryy);
        $num_prod_in_cart = mysqli_num_rows($result);
    }

    echo $num_prod_in_cart;
}

// Calculate total amount
$ip_add = getIPAddress();
$query = "SELECT * FROM `cart_detailles` WHERE ip_adresse='$ip_add'";
$result = mysqli_query($con, $query);
$montant_totale = 0; // Initialize total amount
while ($row = mysqli_fetch_array($result)) {
    $prod_id = $row['id_prod'];
    $products_query = "SELECT * FROM `product_table` WHERE id_prod = '$prod_id'";
    $result1 = mysqli_query($con, $products_query);
    while ($row_price = mysqli_fetch_array($result1)) {
        $pro_price = $row_price['procduct_price']; // Assuming the column name is 'procduct_price'
        $montant_totale += $pro_price;
    }
}

cart();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Website</title>
    <link rel="stylesheet" type="text/css" href="../CSS/css.css">
    <link rel="stylesheet" type="text/css" href="../CSS/css-img.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  
       


 
        <?php 
        if (!isset($_SESSION['username'])) {
            include('login.php');
        } else {
            include('hasna.php');
        }
        ?>



</body>
</html>
