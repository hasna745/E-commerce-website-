<?php 
include("conn/conn.php");

// Function to get the client's IP address
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

// Function to add items to cart
function addToCart($productId, $ipAddress, $con) {
    $query = "SELECT * FROM `cart_detailles` WHERE ip_adresse='$ipAddress' AND id_prod='$productId'";
    $result = mysqli_query($con, $query);
    $numRows = mysqli_num_rows($result);
    
    if ($numRows > 0) {
        echo "<script>alert('This item is already in the cart.');</script>";
    } else {
        $insertQuery = "INSERT INTO `cart_detailles` (id_prod, ip_adresse, quantite_cho) VALUES ('$productId', '$ipAddress', 0)";
        $insertResult = mysqli_query($con, $insertQuery);
        if ($insertResult) {
            echo "<script>alert('Item successfully added to cart.');</script>";
        } else {
            echo "<script>alert('Failed to add item to cart.');</script>";
        }
    }
}

// Check if 'add-to-cart' parameter is set in the URL
if(isset($_GET['add-to-cart'])) {
    $productId = $_GET['add-to-cart'];
    $ipAddress = getIPAddress();
    addToCart($productId, $ipAddress, $con);
}

// Retrieve categories
$categories_query = "SELECT * FROM `categories`";
$categories_result = mysqli_query($con, $categories_query);

// Retrieve products
$products_query = "SELECT * FROM `product_table` ORDER BY RAND() LIMIT 0,20";
$products_result = mysqli_query($con, $products_query);

// Retrieve product details if product ID is provided in the URL
if(isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $product_query = "SELECT * FROM `product_table` WHERE id_prod = $product_id";
    $product_result = mysqli_query($con, $product_query);
    
    if(mysqli_num_rows($product_result) > 0) {
        $product = mysqli_fetch_assoc($product_result);
    } else {
        echo "<p>Product not found.</p>";
    }
} else {
    echo "<p>Product ID not specified.</p>";
}

// Function to display the number of items in the cart
function contenue_cart(){
    global $con;
    $f1 = getIPAddress();
    $queryy = "SELECT * FROM `cart_detailles` WHERE ip_adresse='$f1'";
    $result = mysqli_query($con, $queryy);
    $num_prod_in_cart = mysqli_num_rows($result);
    echo $num_prod_in_cart;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" type="text/css" href="CSS/css.css">
    <link rel="stylesheet" href="serve.css">
    <link rel="stylesheet" type="text/css" href="CSS/css-img.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS for more-detail page -->
    <style>
   .container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: auto;
    width: 100%;
    max-width: 800px; /* Adjusted max-width */
    background-color: #f5f5f5;
    padding: 40px;
    box-sizing: border-box;
}

.product-details {
    display: flex;
    background-color: white;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.image-container {
    flex: 0 0 40%; /* Adjusted width of the image container */
}

.product-image {
    width: 100%;
    height:100%;
    /* Adjusted max-height of the image */
    object-fit: cover;
    border-radius: 10px;
}

.info {
    flex: 1;
    padding: 20px;
    background-color: #f8f9fa; /* Set background color */
    border-radius: 10px; /* Add border-radius for rounded corners */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add box shadow for depth */
}


.product-details h2 {
    font-size: 24px;
    margin-bottom: 15px;
    color: black;
}

.info p {
    margin-bottom: 10px;
    color: black;
}

.delivery-icon {
    color: #28a745;
    margin-right: 5px;
}

.common-details {
    margin-top: 20px;
}

.add-to-cart {
    text-decoration: none;
    color: black;
    background-color: transparent;
    padding: 10px 16px;
    border: 1px solid black;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.add-to-cart:hover {
    background-color: black;
    color: white;
}


    </style>
</head>
<body>
<nav>
        <a href="#" class="logo">𝑬𝑺𝑻𝑬𝑻𝑰𝑪𝑨</a>
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

    <form action="search.php" method="GET">
        <input type="text" name="keywords" placeholder="Enter keywords">
        <button type="submit">Search</button>
    </form>

    <div class="container">
    <div class="product-details">
        <div class="image-container">
            <img src="./admin_page/product_images/<?php echo $product['procduct_image1']; ?>" alt="Product Image" class="product-image">
        </div>
        <div class="info">
            <h2><?php echo isset($product) ? $product['procduct_name'] : 'Product Not Found'; ?></h2>
            <?php if(isset($product)): ?>
                <p style="color: black;">Description: <?php echo $product['procduct_des']; ?></p>
                <p>Price: <?php echo $product['procduct_price']; ?> DH</p>
                <div class="delivery-details">
                    <i class="fas fa-shipping-fast delivery-icon"></i> <div style="color: black;"> Delivery Information: <?php echo $product['delivery_info']; ?></div>
                </div>
                <p>Country: <?php echo $product['country']; ?></p>
                <div class="common-details">
                    <h3 style="color: black;">More Details</h3>
                    <p><?php echo $product['common_details']; ?></p>
                    <a class="add-to-cart" href="homeserve.php?add-to-cart=<?php echo $product['id_prod']; ?>">Add to Cart</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


    
</body>
</html>
