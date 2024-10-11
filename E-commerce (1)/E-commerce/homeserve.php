<?php 
include("conn/conn.php");
session_start();

// Récupération des catégories
$categories_query = "SELECT * FROM `categories`";
$categories_result = mysqli_query($con, $categories_query);

// Récupération des produits
$products_query = "SELECT * FROM `product_table` order by rand() limit 0,20";
$products_result = mysqli_query($con, $products_query);
$img_query = "SELECT * FROM `userinfo`";
$img_result = mysqli_query($con, $img_query);
   
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
            echo "<script>window.open('homeserve.php','_self');</script>";
        } else {
            $queryy = "INSERT INTO `cart_detailles` (id_prod, ip_adresse, quantite_cho) VALUES ('$get_pro_id', '$f1', 0)";
            $result1 = mysqli_query($con, $queryy);
            if($result1) {
                 echo "<script>alert('Item successfully added to cart');</script>";
                echo "<script>window.open('homeserve.php','_self');</script>";
            } else {
                echo "<script>alert('Failed to add item to cart');</script>";
                echo "<script>window.open('homeserve.php','_self');</script>";
            }
        }
    }
}


//DISPLAY WHAT IN THE CART 
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

//globale price 

   
    $ip_add = getIPAddress();
       $query = "SELECT * FROM `cart_detailles` WHERE ip_adresse='$ip_add'";
       $result = mysqli_query($con,$query);
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
    <title>tstitica_casa</title>
    <link rel="shortcut icon" href="https://assets-global.website-files.com/64a2ab71942e1d57feb6fe39/6528221f95333ff155d01ad2_fav.gif" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/locomotive-scroll@3.5.4/dist/locomotive-scroll.css">
    <link rel="stylesheet" href="serve.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="CSS/csssss-img.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="style.css">

    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style type="text/css">
   .gallery {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 2fr));
    gap: 20px;
    padding: 20px;
    position: relative; /* Ensure the gallery container is positioned relatively */
}

.product-container {
    position: relative;
}

.product-container img {
    width: 100%;
    height: 354px;
    display: block;
}

.product-details {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: rgba(255, 255, 255, 0.5);
    padding: 10px;
    box-sizing: border-box;
    transition: background-color 0.3s ease;
}

.product-details:hover {
    background-color: rgba(255, 255, 255, 0.95);
}

.product-details h2 {
    font-size: 18px;
    margin-bottom: 5px;
    color: black;
}

.product-details p {
    font-size: 14px;
    margin-bottom: 5px;
    color: black;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 1; /* Limit to 3 lines */
    -webkit-box-orient: vertical;
}


.product-details .buttons {
    display: flex;
    justify-content: space-between;
}

.product-details .buttons a {
    text-decoration: none;
    color: black;
    padding: 8px 16px;
    border: 1px solid black;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.product-details .buttons a:hover {
    background-color: black;
    color: white;
}


form {
    width: 500px; 
}
.box{

width: 500px;

height: 50px;

background-color: white;

border-radius: 30px;

display: flex;

align-items: center;

padding: 8px;

border-bottom: none; 

}

.box > i {

font-size: 20px;

color: #777;

}

.box > input{

flex: 1;

height: 40px;

border: none;

outline: none;

font-size: 18px;

padding-left: 10px;
}
.box button {
    border-radius: 50%; /* Makes the button circular */
    border: none; /* Remove button border */
    width: 45px; /* Set width to match icon size */
    height: 40px; /* Set height to match icon size */
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


    <div class="bg-light">
        <h3 class="text-center"><i>ESTITICA CASA</i></h3>
        <p class="text-center" id="top-ec">Prolonger dans un monde d'amour pour la décoration</p>
    </div>

    <form action="search.php" method="POST">
    <div class="box">

    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
<input type="text" name="keywords" placeholder="Search for..." style="color: black;">


</div>
    </form>



    <div class="gallery">
     <?php while($row = mysqli_fetch_assoc($products_result)): ?>
         <div class="product-container" data-category="<?php echo $row['id_cat']; ?>">
             <img src="./admin_page/product_images/<?php echo $row['procduct_image1']; ?>" alt="Product Image">
             <div class="product-details">
                 <h2><?php echo $row['procduct_name']; ?></h2>
                 <p><?php echo $row['procduct_des']; ?></p>
                 <p>Price: <?php echo $row['procduct_price']; ?> DH</p>
                 <div class="buttons">
                     <a href="more_detai.php?product_id=<?php echo $row['id_prod']; ?>" class="add-to-cart" name="more-de">More Info</a>
                 <a class="add-to-cart" href="homeserve.php?add-to-cart=<?php echo $row['id_prod']; ?>" >Add to Cart</a>
               </div>
             </div>
         </div>
     <?php endwhile; ?>
 </div>
 
    <footer style="color: gray;">
        <p>Created by estitica-casa</p>
    </footer>


     


</body>
</html>















