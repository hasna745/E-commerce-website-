<?php
// Include the file that establishes database connection
include("../conn/conn.php");
session_start();

// Ensure $con is defined
global $con;

// Récupération des catégories
$categories_query = "SELECT * FROM `categories`";
$categories_result = mysqli_query($con, $categories_query);

// Récupération des produits
$products_query = "SELECT * FROM `product_table` ORDER BY RAND() LIMIT 0,20";
$products_result = mysqli_query($con, $products_query);
$img_query = "SELECT * FROM `userinfo`";
$img_result = mysqli_query($con, $img_query);

// Function to get IP address
function getIPAddress() {  
    // Whether IP is from the shared internet
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }  
    // Whether IP is from the proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
    // Whether IP is from the remote address
    else {  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
}  

// Function to add items to cart
function cart() {
    if (isset($_GET['add-to-cart'])) {
        global $con;
        $get_pro_id = $_GET['add-to-cart'];
        $f1 = getIPAddress();
        $queryy = "SELECT * FROM `cart_detailles` WHERE ip_adresse='$f1' AND id_prod='$get_pro_id'";
        $result = mysqli_query($con, $queryy);
        $num_row = mysqli_num_rows($result);
        if ($num_row > 0) {
            echo "<script>alert('This item is already present inside cart');</script>";
            echo "<script>window.open('home.php','_self');</script>";
        } else {
            $queryy = "INSERT INTO `cart_detailles` (id_prod, ip_adresse, quantite_cho) VALUES ('$get_pro_id', '$f1', 0)";
            $result1 = mysqli_query($con, $queryy);
            if ($result1) {
                echo "<script>alert('Item successfully added to cart');</script>";
                echo "<script>window.open('home.php','_self');</script>";
            } else {
                echo "<script>alert('Failed to add item to cart');</script>";
                echo "<script>window.open('home.php','_self');</script>";
            }
        }
    }
}

// Display items in the cart
function contenue_cart() {
    global $con;
    $f1 = getIPAddress();
    $queryy = "SELECT * FROM `cart_detailles` WHERE ip_adresse='$f1'";
    $result = mysqli_query($con, $queryy);
    $num_prod_in_cart = mysqli_num_rows($result);
    echo $num_prod_in_cart;
}

// Calculate total price of items in the cart
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

// Handle order submission
cart();
$numberr = mt_rand();
$status = 'pending';


$products_query = "SELECT * FROM `userinfo` ";
    $result1 = mysqli_query($con, $products_query);
    while ($row_price = mysqli_fetch_array($result1)) {
        $user_id= $row_price['id']; // Assuming the column name is 'procduct_price'
    }


$sqqq = "INSERT into `orders` (user_id, number, total_amount, total_product, date, status) VALUES ('$user_id', '$numberr', '$montant_totale', 'NOW()', '$status')";
$rss = mysqli_query($con, $sqqq);

if ($rss) {
    echo "<script>alert('Orders are submitted successfully')</script>";
    echo "<script>window.open('profile.php','_self')</script>";
} else {
    echo "<script>alert('Failed to submit order')</script>";
    echo "<script>window.open('../home.php','_self')</script>";
}
?>
