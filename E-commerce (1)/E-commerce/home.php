
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
            echo "<script>window.open('home.php','_self');</script>";
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
    <div id="main">
        <div id="page1">
            <h1>ESTETICA PR<span><svg class="c-bttn__morph" fill="none" viewBox="0 0 131 136">
                        <path class="g-path" data-morph="end" fill="#fff"
                            d="M48 77.457v7.224h7.224l21.307-21.306-7.224-7.225L48 77.457Zm34.118-19.67a1.919 1.919 0 0 0 0-2.716l-4.508-4.508a1.919 1.919 0 0 0-2.716 0l-3.526 3.526 7.224 7.224 3.526-3.525Z">
                        </path>
                        <path class="g-path" data-morph="start" fill="#fff"
                            d="M48 77.457v7.224h7.224l21.307-21.306-7.224-7.225L48 77.457Zm34.118-19.67a1.919 1.919 0 0 0 0-2.716l-4.508-4.508a1.919 1.919 0 0 0-2.716 0l-3.526 3.526 7.224 7.224 3.526-3.525Z"
                            data-original="M65.72 109.14c10.08 0 17.76-3.78 23.04-11.34 5.4-7.68 8.1-17.64 8.1-29.88 0-12.24-2.7-22.2-8.1-29.88-5.28-7.68-12.96-11.52-23.04-11.52-9.96 0-17.7 3.84-23.22 11.52-5.4 7.68-8.1 17.64-8.1 29.88 0 12.12 2.7 22.02 8.1 29.7 5.52 7.68 13.26 11.52 23.22 11.52Zm46.08 7.02c-11.64 12.6-27.06 18.9-46.26 18.9s-34.62-6.3-46.26-18.9C7.76 103.56 2 87.48 2 67.92c0-19.56 5.76-35.64 17.28-48.24C30.92 7.08 46.34.78 65.54.78s34.62 6.3 46.26 18.9c11.64 12.6 17.46 28.68 17.46 48.24 0 19.56-5.82 35.64-17.46 48.24Z">
                        </path>
                    </svg></span>ductS</h1>
            <h1>FOR BETTER VIBE</h1>
            <p>Our shop is dedicated to providing an immersive experience <br>in the world of beauty and self-care.</p>
            <div id="page1-something">
                <h4>ELEGANCE</h4>
                <h4>AND BEAUTY</h4>
                <h4>with</h4>
                <h4><ESTETIC>ESTETICA SHOP</ESTETIC></h4>
            </div>
            <div id="moving-div">
                <div id="blur-left"></div>
                <div class="move">
                    <p>WELCOME TO OUR SPACE , WORLD OF VASES FOR YOUR OWN ENVIRNMENT WELCOME TO OUR SPACE , WORLD OF VASES FOR YOUR OWN ENVIRNMENT WELCOME TO OUR SPACE , WORLD OF VASES FOR YOUR OWN ENVIRNMENT</p>
                   
                </div>
                <div class="move">
                    <p>WELCOME TO OUR SPACE , WORLD OF VASES FOR YOUR OWN ENVIRNMENT WELCOME TO OUR SPACE , WORLD OF VASES FOR YOUR OWN ENVIRNMENT WELCOME TO OUR SPACE , WORLD OF VASES FOR YOUR OWN ENVIRNMENT</p>

                </div>
                <div id="blur-right"></div>

            </div>
        </div>
        <div id="page2">
            <div id="page2-left">
                <p><br>Welcome guest</p>
                <h5>Embracing innovation in design and craftsmanship, we at 𝑬𝑺𝑻𝑬𝑻𝑰𝑪𝑨 are dedicated to curating knowledge, sharing insights, and offering expert advice. From unveiling the latest trends to showcasing our meticulous workmanship, we strive to elevate your experience and inspire creativity</h5>
            </div>
            <div id="page2-right">
                <div class="right-elem" id="right-elem1">
                    <h2>Elevate Your Home Decor with Exquisite Vases from Estetica</h2>
                    <img src="https://i.pinimg.com/564x/62/c7/ff/62c7ffd1435181a5d75cbb94d5dc01f9.jpg"
                        alt="">
                </div>
                <div class="right-elem">
                    <h2>Discover Timeless Elegance: Shop Unique Vases at Estetica</h2>
                    <img src="https://i.pinimg.com/564x/a7/0c/14/a70c1460d39fda9df961ad3a6860b0ed.jpg"
                        alt="">
                </div>
                <div class="right-elem">
                    <h2>Add a Touch of Sophistication to Your Space with Estetica's Vase Collection</h2>
                    <img src="https://i.pinimg.com/564x/84/e6/ee/84e6ee8a271c49649ac4e7a0a3daf88c.jpg"
                        alt="">
                </div>
                <div class="right-elem">
                    <h2>Transform Your Home into a Haven of Style with Estetica's Stunning Vases</h2>
                    <img src="https://i.pinimg.com/564x/d9/49/45/d94945fcca53c92aa407122342bb86e1.jpg"
                        alt="">
                </div>
            </div>

        </div>
        <div id="page3">
            <video src="artvase.mp4" muted="" ></video>
            <div class="page3-center">
                <div class="icon">
                    <i class="ri-play-fill"></i>
                </div>
                <h5>Watch Showreel</h5>
            </div>
        </div>
        <div id="page4">
            <div class="section">
                <div class="sec-left">
                    <h2>BUD VASE|SHOP NOW</h2>
                    <a href="category.php?cat_id=44">BUD VASE</a>
                    <p>Bud vases are tiny vessels for single flowers. Perfect for freshening up tables or desks, they come in a variety of styles to showcase the beauty of flowers.</p>
                </div>
                <div class="sec-right">
                     <a href="category.php?cat_id=44">
    <img src="imm/111.jpg" alt="Bud vase">
</a>
                </div>
            </div>
            <div class="section">
                <div class="sec-left">
                    <a href="category.php?cat_id=45">WOODEN VASE|SHOP NOW</a>

                    <p>A wooden vase is a container typically crafted from wood, used for displaying flowers or as a decorative piece. It adds a rustic and natural touch to any space, with various designs ranging from simple and sleek to intricately carved. Wooden vases come in different types of wood, finishes, and sizes, allowing for versatility in styling and complementing various decor themes.</p>
                </div>
                <div class="sec-right">
                    <a href="category.php?cat_id=45">
    <img src="admin_page/product_images/VASE%20CERAMIQUE/1.webp" alt="wooden vase">
</a>
                </div>
            </div>
          <div class="section">
                <div class="sec-left">
                   
                     <a href="category.php?cat_id=46">MASON JAR|SHOP NOW</a>
                    <p>
A Mason jar is a type of glass jar with a screw-on lid, originally designed for home canning purposes. However, it has become widely popular for various uses beyond canning. Mason jars are often used as drinking glasses, storage containers, or decorative elements in home decor.</p>
                </div>
                <div class="sec-right">
                    <a href="category.php?cat_id=46">
    <img src="imm/44.jpg" alt="Mason jar">
</a>
                    
                </div>
            </div>

               <div class="section">
                <div class="sec-left">
                    <a href="category.php?cat_id=47">NARROW NECK VASE|SHOP NOW</a>
                    <p>The Narrow Neck Vase is a classic vessel characterized by its elongated body and slender opening. Originating from ancient civilizations like Greece and Rome, it was primarily used for storing liquids such as wine or oil. Its design features a practical narrow neck, which prevents spills and allows for controlled pouring.</p>
                </div>
                <div class="sec-right">
                   <a href="category.php?cat_id=47">
    <img src="admin_page/product_images/vases/narrow neck vase/produit7/img7-1.jpg" alt="Narrow Neck Vase">
</a>
                    
                </div>
            </div>

          <div class="section">
                <div class="sec-left">
                    <a href="category.php?cat_id=48">URN VASE|SHOP NOW</a>
                    <p> An urn vase is vase shaped like a classical urn, narrow neck, and flared rim. It's often used for decoration or displaying flowers, drawing inspiration from ancient funerary urns.</p>
                </div>
                <div class="sec-right">
                     <a href="category.php?cat_id=48">
    <img src="admin_page/product_images/vases/urn/produit7/img7-1.webp" alt="urn vase">
</a>


                </div>
            </div>


            <div class="section">
                <div class="sec-left">
                  
                    <a href="category.php?cat_id=49">LIGHT-UP VASE|SHOP NOW</a>
                    <p>A light-up vase is a decorative container designed to hold flowers or other objects, featuring built-in lighting elements. These vases typically have translucent or transparent walls that allow light to shine through, creating a soft, ambient glow. They often use LED technology for illumination, which can be customized to change colors or brightness levels.</p>
                </div>
                <div class="sec-right">
                   


                        <a href="category.php?cat_id=49">
    <img src="imm/77.jpg" alt="light-up vase">
</a>

                   
                </div>
            </div>

                    <div class="section">
                <div class="sec-left">
                   
                    <a href="category.php?cat_id=50">CERAMIC VASE|SHOP NOW</a>
                    <p>A ceramic vase is a vessel made from clay that has been shaped, dried, and fired in a kiln to harden it into its final form. These vases come in a variety of shapes, sizes, and styles, ranging from simple and functional to intricately decorated works of art. </p>
                </div>
                <div class="sec-right">
                    <a href="category.php?cat_id=50">
    <img src="imm/OOO.webp" alt="Wooden Vase">
</a>

                    
                </div>
            </div>


        </div>
       
        <div id="page5">
            <button ><a style="color: black;" href="users/login.php"> Become a Client </a>  </button>
            <div id="page5-right">
<p><span></span>At estetica, we lead your vase adventure <span></span>of delivering unmatched personal attention at every encounter. Whether you're launching new collections, reimagining existing designs, attracting investment with captivating prototypes, fostering customer connections, or maximizing sales, we offer a range of custom-designed services tailored specifically for your vase business.</p>
                <div id="page5-content">
                    <div class="uiux">
                        <details open>
                            <summary>
                                <h1>Vase Design</h1>
                                <div id="flex">
                                    <h4>Vase Collection Curation</h4>
    <h4>Vase Presentation</h4>
    <h4>Vase Design</h4>
    <h4>Vase Market Research</h4>
                                </div>
                            </summary>
                           <div id="page-container">
    <div class="page5-elem">
        <div class="over"></div>
        <h3>Vase Inspiration at Estetica</h3>
        <p>Discover the latest trends and insights in vase design at Estetica. Explore our curated selection of exquisite vases, crafted to elevate your home decor and express your unique style.</p>
        <i class="ri-arrow-right-up-line"></i>
    </div>
    <div class="page5-elem">
        <div class="over"></div>
        <h3>Vase Design at Estetica</h3>
        <p>Experience the artistry of vase design with our exclusive collection at Estetica. Each vase is meticulously crafted to blend form and function, creating stunning pieces that captivate the eye and enhance any space.</p>
        <i class="ri-arrow-right-up-line"></i>
    </div>
    <div class="page5-elem">
        <div class="over"></div>
        <h3>Vase Presentation at Estetica</h3>
        <p>Elevate your home decor with our beautifully presented vases at Estetica. Whether displayed as a centerpiece or accent piece, our vases add a touch of sophistication and elegance to any room.</p>
        <i class="ri-arrow-right-up-line"></i>
    </div>
    <div class="page5-elem">
        <div class="over"></div>
        <h3>Vase Market Research at Estetica</h3>
        <p>Stay ahead of the curve with our comprehensive vase market research at Estetica. We analyze industry trends and consumer preferences to ensure our collection reflects the latest demands and innovations in vase design.</p>
        <i class="ri-arrow-right-up-line"></i>
    </div>
</div>

                        </details>
                    </div>
                    <div class="product">
                        <details>
                            <summary>
                                
                            </summary>
                           
                        </details>
                    </div>
                </div>
            </div>
        </div>
        <div id="page6">
    <h1>Contact Us</h1>
    <div id="page6-content">
        <div id="blue-btn">
            <h4><a href="contpage.php">Get in Touch</a> <i class="ri-arrow-right-up-line"></i></h4>
            <h4><a style="color: black;" href="contpage.php">Get in Touch</a><i class="ri-arrow-right-up-line"></i></h4>
        </div>
        <div id="right-6">
            <p>At Estetica, we're dedicated to providing exceptional service and assisting you with any inquiries you may have. Whether you're seeking assistance with a purchase, have questions about our products, or need help with a custom order, our team is here to help.</p>
            <p>Feel free to reach out to us via email, phone, or by filling out the contact form below. We look forward to hearing from you!</p>
        </div>
    </div>
    <div id="page6-bottom">
        <div id="btm6-part1" class="btm6-parts"></div>
        <div id="btm6-part2" class="btm6-parts">
            <h5>Contact Information</h5>
            <h4><span>Email:</span> Contact@estiticacsa.com</h4>
            <h4><span>Phone:</span> +212 5 22 99 09 35</h4>
            <h4><span>Address:</span> 103 Rue Omar Al Khayam
103 Rue Omar Al Khayam, Dar-el-Beida 20250</h4>
        </div>
        <div id="btm6-part3" class="btm6-parts">
            <h5>Business Hours</h5>
            <h4><span>Monday-Friday:</span> 9:00AM-6:00PM</h4>
            <h4><span>Saturday:</span> 10:00AM-4:00PM</h4>
            <h4><span>Sunday:</span> Closed</h4>
        </div>
        <div id="btm6-part5" class="btm6-parts"></div>
    </div>
</div>

        <div id="page7">
              <p style="display: center;">&copy; 2024 Estiticacasa - Site created by <a href="#">estiticacasa</a></p>
  

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/locomotive-scroll@3.5.4/dist/locomotive-scroll.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"
        integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"
        integrity="sha512-onMTRKJBKz8M1TnqqDuGBlowlH0ohFzMXYRNebz+yOcc5TQr/zAKsthzhuv0hiyUKEiQEQXEynnXCvNTOk50dg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="serve.js"></script>
</body>

</html>