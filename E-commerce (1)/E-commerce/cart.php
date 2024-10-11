<?php 
include("conn/conn.php");
session_start();

// Retrieve categories
$categories_query = "SELECT * FROM `categories`";
$categories_result = mysqli_query($con, $categories_query);

// Retrieve products
$products_query = "SELECT * FROM `product_table` ORDER BY RAND() LIMIT 0,20";
$products_result = mysqli_query($con, $products_query);
   
function getIPAddress() {  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    } else {  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
}  

if(
isset($_SESSION['username'])) {
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
                $queryy = "INSERT INTO `cart_detailles` (id_prod, ip_adresse) VALUES ('$get_pro_id', '$f1')";
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

    // Display items in the cart 
    function contenue_cart(){
        if(!isset($_GET['add-to-cart'])) {
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

    // Initialize total amount to 0
    $montant_total = 0;

    // Calculate total amount of the cart
    $ip_add = getIPAddress();
    $query = "SELECT * FROM `cart_detailles` WHERE ip_adresse='$ip_add'";
    $result = mysqli_query($con,$query);
    $cont_tba=mysqli_num_rows($result);
    if($cont_tba>0){
        while ($row = mysqli_fetch_array($result)) {
            $prod_id = $row['id_prod'];
            $prod_qua = $row['quantite_cho'];

            $products_query = "SELECT * FROM `product_table` WHERE id_prod = '$prod_id'";
            $result1 = mysqli_query($con, $products_query);
            while ($row_price = mysqli_fetch_array($result1)) {
                $pro_price = $row_price['procduct_price'];
                $montant_total += ($pro_price * $prod_qua);
            }
        }
    } 

    // Process updating quantity in the cart
    if(isset($_POST['upd_cart'])) {
        global $con;
        $quantities = $_POST['qtt'];
        $prod_ids = $_POST['id_prod'];
        $num_items = count($quantities);

        // Parcourir chaque produit dans le panier
        for($i = 0; $i < $num_items; $i++) {
            $qty = intval($quantities[$i]);
            $prod_id = intval($prod_ids[$i]);

            // Récupérer la quantité en stock du produit
            $query_stock = "SELECT quan_stock FROM `product_table` WHERE id_prod='$prod_id'";
            $result_stock = mysqli_query($con, $query_stock);
            $row_stock = mysqli_fetch_assoc($result_stock);
            $stock_available = intval($row_stock['quan_stock']);

            // Vérifier si la quantité demandée est disponible en stock
            if ($qty <= $stock_available) {
                // Mettre à jour la quantité dans le panier
                $update_query = "UPDATE `cart_detailles` SET quantite_cho='$qty' WHERE id_prod='$prod_id'";
                mysqli_query($con, $update_query);

                // Mettre à jour la quantité en stock dans la base de données
                $new_stock = $stock_available - $qty;
                $update_stock_query = "UPDATE `product_table` SET quan_stock='$new_stock' WHERE id_prod='$prod_id'";
                mysqli_query($con, $update_stock_query);
            } else if($qty > $stock_available) {
                // Afficher un message d'erreur si la quantité demandée n'est pas disponible en stock
                echo "<script>alert('La quantité demandée pour le produit n'est pas disponible en stock');</script>";
            }
        }
    }

    cart();

} else {
    // Redirection vers la page de connexion
    header("Location: users/login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Website</title>
    <link rel="stylesheet" type="text/css" href="CSS/css.css">
    <link rel="stylesheet" type="text/css" href="CSS/css-img.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="shortcut icon" href="https://assets-global.website-files.com/64a2ab71942e1d57feb6fe39/6528221f95333ff155d01ad2_fav.gif" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/locomotive-scroll@3.5.4/dist/locomotive-scroll.css">
    <link rel="stylesheet" href="serve.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="CSS/csssss-img.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .gallery {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
}

.product-container {
    background-color: #f9f9f9;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.product-container img {
    width: 100%;
    height: auto;
    display: block;
}

.product-details {.product-container {
    display: flex;
    flex-direction: column;
    background-color: #f9f9f9;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.product-image {
    flex: 1;
}

.product-image img {
    width: auto;
    height: auto;
    object-fit: cover; /* Ensure the image covers the entire container */
    display: block;
}

.product-details {
    padding: 20px;
}

.product-details h2 {
    font-size: 18px;
    margin-bottom: 10px;
}

.product-details p {
    font-size: 14px;
    margin-bottom: 10px;
}

.product-details .buttonss {
    margin-top: auto;
}

.product-details .buttonss a {
    display: inline-block;
    padding: 8px 16px;
    margin-right: 10px;
    text-decoration: none;
    color: #fff;
    background-color: #007bff;
    border-radius: 5px;
}

.product-details .buttonss a:hover {
    background-color: #0056b3;
}

    padding: 20px;
}

.product-details h2 {
    font-size: 18px;
    margin-bottom: 10px;
     color: black; 
}

.product-details p {
    font-size: 14px;
    margin-bottom: 10px;
    color: black; /* Set the text color to white */
}

.product-details .buttonss {
    margin-top: 10px;
}

.product-details .buttonss a {
    display: inline-block;
    padding: 8px 16px;
    margin-right: 10px;
    text-decoration: none;
    color: #fff;
    background-color: #007bff;
    border-radius: 5px;
}

.product-details .buttonss a:hover {
    background-color: #0056b3;
}
        .table {
            width: 100%;
            border-collapse: collapse;
             color: black;
        }
        .table th,
        .table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
             color: black;
        }
        .table th {
            background-color: #f2f2f2;
             color: black;
        }
        /* Image styles */
        .image img {
            max-width: 100px;
            height: auto;
            display: block;
            margin: 0 auto;
             color: black;
        }
        /* Centering text in the last column */
        .table td:last-child {
            text-align: center;
             color: black;
        }
        .mmoi{
             color: black;
        }
    </style>
</head>
<body>
    <nav>
        <a href="#" class="logo">ESTITICA</a>
        <div class="nav-part2">
        
    
             <a href="home.php">home</a>
                <a href="contpage.php" target="_blank">contact</a>
                <a href="homeserve.php">products</a>

                 <li>
            <a href="#" id="categories-title">Categories</a>
<ul class="dropdown" id="categories-list" style="display: none;">
    <?php while($row = mysqli_fetch_assoc($categories_result)): ?>
        <li><a href="category.php?cat_id=<?php echo $row['id_cat']; ?>" class="category-link"><?php echo $row['nom_cat']; ?></a> </li>
    <?php endwhile; ?>
</ul>
 



 <a href="users/login.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0z"/>
  <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
</svg></a>
<a href="users/profile.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
</svg></a>

 <a href="cart.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16"><path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/></svg> <sup><?php  contenue_cart(); ?></sup></a>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("categories-title").addEventListener("click", function() {
            var categoriesList = document.getElementById("categories-list");
            if (categoriesList.style.display === "none") {
                categoriesList.style.display = "block";
            } else {
                categoriesList.style.display = "none";
            }
        });
    });
</script>
            
        </div>
        
        

        </div>
    </nav>

<pre>
    <!-- Table for items added to the cart -->
    <?php if($cont_tba>0){ ?>
    <div class="container">
        <div class="row">


            <form action="" method="post">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product Title</th>
                            <th>Product Image</th>
                            <th>Quantity</th> 
                            <th>Total Price</th>
                            <th>Remove</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $ip_add = getIPAddress();
                            $query = "SELECT * FROM `cart_detailles` WHERE ip_adresse='$ip_add'";
                            $result = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_array($result)) {
                                $prod_id = $row['id_prod'];
                                $products_query = "SELECT * FROM `product_table` WHERE id_prod = '$prod_id'";
                                $result1 = mysqli_query($con, $products_query);
                                while ($row_price = mysqli_fetch_array($result1)) {
                                    $pro_price = $row_price['procduct_price'];
                                    $pro_title = $row_price['procduct_name'];
                                    $pro_img = $row_price['procduct_image1'];
                        ?>
                        <tr>
                            <td><?php echo $pro_title; ?></td>
                            <td class="image"><img src="./admin_page/product_images/<?php echo $row_price['procduct_image1']; ?>" alt=""></td>
                            <input type="hidden" name="id_prod[]" value="<?php echo $prod_id; ?>">
                            <td class="mmoi" style="color: black;" ><input  style="color: black;" type="number" name="qtt[]" value="<?php echo $row['quantite_cho']; ?>"></td>
                            <td class="mmoi"><?php echo $pro_price; ?></td> 
                            <td><input type="checkbox" name="remove_it[]" value="<?php echo $prod_id; ?>"></td>
                            <td>
                                <p style="color: blue; font-style: italic;">Please click update & remove twice</p>
                                <div class="buttonss">
                                    <input type="submit" name="upd_cart" class="add-to-cart" value="Update"  style="display: inline-block; background-color: black; color: white; text-decoration: none; padding: 10px 20px; margin: 10px; border-radius: 5px;"> 
                                    <input type="submit" name="rmcart" class="add-to-cart" value="Remove" style="display: inline-block; background-color: black; color: white; text-decoration: none; padding: 10px 20px; margin: 10px; border-radius: 5px;"> 
                                </div>      
                            </td>
                        </tr>
                        <?php } } ?>
                    </tbody> 
                </table>
            </form>
        </div>
    </div>
</pre>

 <h3 class="mmoi" >Total amount:</h3> <p class="mmoi"><?php echo isset($montant_total) ? $montant_total : 0; ?> DH</p>




 <div class="buttonss">
    <a href="home.php" class="hh" name="more-de" style="display: inline-block; background-color: black; color: white; text-decoration: none; padding: 10px 20px; margin: 10px; border-radius: 5px;">Continue Shopping</a>
    <a href="users/Checkout.php" class="hh" name="more-de" style="display: inline-block; background-color: black; color: white; text-decoration: none; padding: 10px 20px; margin: 10px; border-radius: 5px;">Checkout</a>
</div>

    <?php }else {
    echo "<h2 class='text-center  text-danger'>Cart is empty</h2>"; // Display message if cart is empty
} ?> 


</body>
</html>

<?php 
// Vérifie si l'utilisateur est connecté
if(isset($_SESSION['username'])) {
    // Récupère le nom d'utilisateur à partir de la session
    $username = $_SESSION['username'];

    // Parcourt chaque produit dans le panier
    $ip_add = getIPAddress();
    $query = "SELECT * FROM `cart_detailles` WHERE ip_adresse='$ip_add'";
    $result = mysqli_query($con,$query);
    while ($row = mysqli_fetch_array($result)) {
        $prod_id = $row['id_prod'];
        $prod_qua = $row['quantite_cho'];

        // Vérifie si le produit existe déjà dans la table "orders"
        $check_order_query = "SELECT * FROM orders WHERE product_name = ? AND username = ?";
        $stmt_check = mysqli_prepare($con, $check_order_query);
        mysqli_stmt_bind_param($stmt_check, "ss", $pro_title, $username);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
        $num_rows = mysqli_stmt_num_rows($stmt_check);

        if($num_rows == 0) {
            // Récupère les informations du produit depuis la table "product_table"
            $products_query = "SELECT * FROM `product_table` WHERE id_prod = '$prod_id'";
            $result1 = mysqli_query($con, $products_query);
            while ($row_price = mysqli_fetch_array($result1)) {
                $pro_title = $row_price['procduct_name'];
                $pro_price = $row_price['procduct_price'];

                // Calcule le prix total du produit
                $total_price = $pro_price * $prod_qua;

                // Insère les données dans la table "orders"
                $insert_order_query = "INSERT INTO orders (product_name, quantity, unit_price, total_price, username) VALUES (?, ?, ?, ?, ?)";
                $stmt_insert = mysqli_prepare($con, $insert_order_query);
                mysqli_stmt_bind_param($stmt_insert, "sidds", $pro_title, $prod_qua, $pro_price, $total_price, $username);
                mysqli_stmt_execute($stmt_insert);
            }
        }
    }
}

// Supprime les produits du panier et de la table "orders" si l'utilisateur les supprime du panier
if(isset($_POST['rmcart'])) {
    global $con;
    foreach ($_POST['remove_it'] as $rmevv) {
        $dele_qu = "DELETE FROM `cart_detailles` WHERE id_prod='$rmevv'";
        $run_re = mysqli_query($con, $dele_qu);
        if($run_re) {
            // Supprime les entrées correspondantes de la table "orders"
            $delete_order_query = "DELETE FROM orders WHERE product_name = (SELECT procduct_name FROM product_table WHERE id_prod = '$rmevv') AND username = '$username'";
            mysqli_query($con, $delete_order_query);
        }
    }
}


?>
