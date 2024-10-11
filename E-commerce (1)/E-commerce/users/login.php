<?php 
session_start();

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

function geIPAddress() {  
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

function crt() {
    if(isset($_GET['add-to-cart'])) {
        global $con;
        $get_pro_id = $_GET['add-to-cart'];
        $f1 = geIPAddress();
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

function cotenue_cart(){
    if(isset($_GET['add-to-cart'])) {
        global $con;
        $f1 = geIPAddress();
        $queryy = "SELECT * FROM `cart_detailles` WHERE ip_adresse='$f1'";
        $result = mysqli_query($con, $queryy);
        $num_prod_in_cart = mysqli_num_rows($result);
    } else {
        global $con;
        $f1 = geIPAddress();
        $queryy = "SELECT * FROM `cart_detailles` WHERE ip_adresse='$f1'";
        $result = mysqli_query($con, $queryy);
        $num_prod_in_cart = mysqli_num_rows($result);
    }

    echo $num_prod_in_cart;
}

// Calculate total amount
$ip_add = geIPAddress();
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

crt();
?>













<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="style.css" />
    <title>Sign in & Sign up Form</title>

    <style>

@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body,
input {
  font-family: "Poppins", sans-serif;
}

.container {
  position: relative;
  width: 100%;
  background-color: #fff;
  min-height: 100vh;
  overflow: hidden;
}

.forms-container {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
}

.signin-signup {
  position: absolute;
  top: 50%;
  transform: translate(-50%, -50%);
  left: 75%;
  width: 50%;
  transition: 1s 0.7s ease-in-out;
  display: grid;
  grid-template-columns: 1fr;
  z-index: 5;
}

form {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 0rem 5rem;
  transition: all 0.2s 0.7s;
  overflow: hidden;
  grid-column: 1 / 2;
  grid-row: 1 / 2;
}

form.sign-up-form {
  opacity: 0;
  z-index: 1;
}

form.sign-in-form {
  z-index: 2;
}

.title {
  font-size: 2.2rem;
  color: #444;
  margin-bottom: 10px;
}

.input-field {
  max-width: 380px;
  width: 100%;
  background-color: #f0f0f0;
  margin: 10px 0;
  height: 55px;
  border-radius: 55px;
  display: grid;
  grid-template-columns: 15% 85%;
  padding: 0 0.4rem;
  position: relative;
}

.input-field i {
  text-align: center;
  line-height: 55px;
  color: #acacac;
  transition: 0.5s;
  font-size: 1.1rem;
}

.input-field input {
  background: none;
  outline: none;
  border: none;
  line-height: 1;
  font-weight: 600;
  font-size: 1.1rem;
  color: #333;
}

.input-field input::placeholder {
  color: #aaa;
  font-weight: 500;
}

.social-text {
  padding: 0.7rem 0;
  font-size: 1rem;
}

.social-media {
  display: flex;
  justify-content: center;
}

.social-icon {
  height: 46px;
  width: 46px;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 0.45rem;
  color: #333;
  border-radius: 50%;
  border: 1px solid #333;
  text-decoration: none;
  font-size: 1.1rem;
  transition: 0.3s;
}

.social-icon:hover {
  color: #4481eb;
  border-color: #4481eb;
}

.btn {
  width: 150px;
  background-color: gray;
  border: none;
  outline: none;
  height: 49px;
  border-radius: 49px;
  color: #fff;
  text-transform: uppercase;
  font-weight: 600;
  margin: 10px 0;
  cursor: pointer;
  transition: 0.5s;
}

.btn:hover {
  background-color: black;
}
.panels-container {
  position: absolute;
  height: 100%;
  width: 100%;
  top: 0;
  left: 0;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
}

.container:before {
  content: "";
  position: absolute;
  height: 2000px;
  width: 2000px;
  top: -10%;
  right: 48%;
  transform: translateY(-50%);
  background-image: linear-gradient(-45deg, black 0%, #181818 100%);
  transition: 1.8s ease-in-out;
  border-radius: 50%;
  z-index: 6;
}

.image {
  width: 100%;
  transition: transform 1.1s ease-in-out;
  transition-delay: 0.4s;
}

.panel {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  justify-content: space-around;
  text-align: center;
  z-index: 6;
}

.left-panel {
  pointer-events: all;
  padding: 3rem 17% 2rem 12%;
}

.right-panel {
  pointer-events: none;
  padding: 3rem 12% 2rem 17%;
}

.panel .content {
  color: #fff;
  transition: transform 0.9s ease-in-out;
  transition-delay: 0.6s;
}

.panel h3 {
  font-weight: 600;
  line-height: 1;
  font-size: 1.5rem;
}

.panel p {
  font-size: 0.95rem;
  padding: 0.7rem 0;
}

.btn.transparent {
  margin: 0;
  background: none;
  border: 2px solid #fff;
  width: 130px;
  height: 41px;
  font-weight: 600;
  font-size: 0.8rem;
}

.right-panel .image,
.right-panel .content {
  transform: translateX(800px);
}

/* ANIMATION */

.container.sign-up-mode:before {
  transform: translate(100%, -50%);
  right: 52%;
}

.container.sign-up-mode .left-panel .image,
.container.sign-up-mode .left-panel .content {
  transform: translateX(-800px);
}

.container.sign-up-mode .signin-signup {
  left: 25%;
}

.container.sign-up-mode form.sign-up-form {
  opacity: 1;
  z-index: 2;
}

.container.sign-up-mode form.sign-in-form {
  opacity: 0;
  z-index: 1;
}

.container.sign-up-mode .right-panel .image,
.container.sign-up-mode .right-panel .content {
  transform: translateX(0%);
}

.container.sign-up-mode .left-panel {
  pointer-events: none;
}

.container.sign-up-mode .right-panel {
  pointer-events: all;
}

@media (max-width: 870px) {
  .container {
    min-height: 800px;
    height: 100vh;
  }
  .signin-signup {
    width: 100%;
    top: 95%;
    transform: translate(-50%, -100%);
    transition: 1s 0.8s ease-in-out;
  }

  .signin-signup,
  .container.sign-up-mode .signin-signup {
    left: 50%;
  }

  .panels-container {
    grid-template-columns: 1fr;
    grid-template-rows: 1fr 2fr 1fr;
  }

  .panel {
    flex-direction: row;
    justify-content: space-around;
    align-items: center;
    padding: 2.5rem 8%;
    grid-column: 1 / 2;
  }

  .right-panel {
    grid-row: 3 / 4;
  }

  .left-panel {
    grid-row: 1 / 2;
  }

  .image {
    width: 200px;
    transition: transform 0.9s ease-in-out;
    transition-delay: 0.6s;
  }

  .panel .content {
    padding-right: 15%;
    transition: transform 0.9s ease-in-out;
    transition-delay: 0.8s;
  }

  .panel h3 {
    font-size: 1.2rem;
  }

  .panel p {
    font-size: 0.7rem;
    padding: 0.5rem 0;
  }

  .btn.transparent {
    width: 110px;
    height: 35px;
    font-size: 0.7rem;
  }

  .container:before {
    width: 1500px;
    height: 1500px;
    transform: translateX(-50%);
    left: 30%;
    bottom: 68%;
    right: initial;
    top: initial;
    transition: 2s ease-in-out;
  }

  .container.sign-up-mode:before {
    transform: translate(-50%, 100%);
    bottom: 32%;
    right: initial;
  }

  .container.sign-up-mode .left-panel .image,
  .container.sign-up-mode .left-panel .content {
    transform: translateY(-300px);
  }

  .container.sign-up-mode .right-panel .image,
  .container.sign-up-mode .right-panel .content {
    transform: translateY(0px);
  }

  .right-panel .image,
  .right-panel .content {
    transform: translateY(300px);
  }

  .container.sign-up-mode .signin-signup {
    top: 5%;
    transform: translate(-50%, 0);
  }
}

@media (max-width: 570px) {
  form {
    padding: 0 1.5rem;
  }

  .image {
    display: none;
  }
  .panel .content {
    padding: 0.5rem 1rem;
  }
  .container {
    padding: 1.5rem;
  }

  .container:before {
    bottom: 72%;
    left: 50%;
  }

  .container.sign-up-mode:before {
    bottom: 28%;
    left: 50%;
  }
}

.input-pair {
    display: flex;
    justify-content: space-between;
    width: 100%;
    margin-bottom: 15px;
}
    </style>
  </head> 
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="#" class="sign-in-form" method="post">
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Username" name="username" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Password" name="pass" />
            </div>
            <input type="submit"  name ="submi" value="Login" class="btn solid" />
            <p class="social-text">Or Sign in with social platforms</p>
            <div class="social-media">
    <a href="https://accounts.google.com/o/oauth2/auth" class="social-icon">
        <i class="fab fa-google"></i>
    </a>
    <a href="https://www.facebook.com/v12.0/dialog/oauth" class="social-icon">
        <i class="fab fa-facebook-f"></i>
    </a>
    <a href="https://api.twitter.com/oauth/authenticate" class="social-icon">
        <i class="fab fa-twitter"></i>
    </a>
    <a href="https://www.linkedin.com/oauth/v2/authorization" class="social-icon">
        <i class="fab fa-linkedin-in"></i>
    </a>
</div>
          </form>
          <form action="" class="sign-up-form" method="post" enctype="multipart/form-data">
            <h2 class="title">Sign up</h2>
            <div class="input-pair">
        <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="prenom" id="prenom" placeholder="First name" />
        </div>
        <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="nom" id="nom" placeholder="Last name" />
        </div>
    </div>
    <div class="input-pair">
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username" id="username" placeholder="Username" />
            </div>

            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="text" name="email" id="email" placeholder="Email" />
            </div>
            </div>
            <div class="input-pair">
            <div class="input-field">
              <i  class="fas fa-phone phone-icon"></i>
              <input type="number" name="tele" id="tele" placeholder="Phone number" />
            </div>


            <div class="input-field">
              <i  class="fas fa-map-marker-alt address-icon"></i>
              <input type="text" name="adresse" id="adresse" placeholder="Adresse" />
            </div>
            </div>

            <div class="input-pair">
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input  type="password" name="pass" id="pass" placeholder="Password" />
            </div>


            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input  type="password" name="c_pass" id="c_pass" placeholder="Confirm Password" />
            </div>
            </div>

            <div class="input-pair">
            <div>
 
              <input type="file" name="img" id="img" />
            </div>


            <div>
              <label for="sexe">Sexe</label> <br>
                    <input type="radio" name="sexe" value="Homme"> Homme
                    <input type="radio" name="sexe" value="Femme"> Femme
            </div>
            </div>


            <div class="input-pair">
            <div>
 
              <input type="number" name="age" placeholder="age" />
            </div>
            </div>
            <input type="submit"  name ="submit" class="btn" value="Sign up" />
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>New here ?</h3>
            <p>
            Welcome! We're thrilled to have you as our newest client.
             Let's embark on this journey together.
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="img/log.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>One of us ?</h3>
            <p>
            Welcome back! It's great to see you again as part of our community.
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="img/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>

    <script>
        const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});
    </script>



<?php
// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];
    $age = $_POST['age'];
    $sexe = $_POST['sexe'];
    $email = $_POST['email'];
    $telephone = $_POST['tele'];
    $adresse = $_POST['adresse'];
    $password = $_POST['pass'];
    $password_conf = $_POST['c_pass'];
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $user_ip = $_SERVER['REMOTE_ADDR'];
    
    // Define upload folder
    $upload_folder = "../images/user_images/";

    // Check if required fields are not empty
    if (!empty($nom) && !empty($prenom) && !empty($age) && !empty($sexe) && !empty($email) && !empty($telephone) && !empty($_FILES['img']['name'])) {
        
        // Check if passwords match
        if ($password != $password_conf) {
            echo '<div id="warning-alert">Please enter the same password.</div>';
            exit(); // Stop further execution
        }
        
        // Check if email and username are unique
        $result = mysqli_query($con, "SELECT * FROM `userinfo` WHERE email='$email' OR username='$username'");
        if (!$result) {
            echo "Error checking email or username: " . mysqli_error($con);
            exit(); // Stop further execution
        }
        
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            echo '<div id="warning-alert">Email or username already exists.</div>';
            exit(); // Stop further execution
        }
        
        // Move uploaded image to the destination folder
        $img_name = $_FILES['img']['name'];
        $img_tmp = $_FILES['img']['tmp_name'];
        if (!move_uploaded_file($img_tmp, $upload_folder . $img_name)) {
            echo "Error uploading image.";
            exit(); // Stop further execution
        }

        // Prepare the SQL statement with placeholders
        $sql = "INSERT INTO `userinfo` (nom, prenom, username, age, sexe, email, tele, adresse, password, image_path, ip_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = mysqli_prepare($con, $sql);

        // Bind parameters to the statement
        mysqli_stmt_bind_param($stmt, "sssisssssss", $nom, $prenom, $username, $age, $sexe, $email, $telephone, $adresse, $hashed_password, $img_name, $user_ip);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo '<div id="s-alert">Your data has been saved successfully!</div>';

            // Check if the user has items in the cart and redirect accordingly
            $select_cart_items = "SELECT * FROM cart_detailles WHERE ip_adresse='$user_ip'";
            $result_cart = mysqli_query($con, $select_cart_items);
            $rows_count = mysqli_num_rows($result_cart);

            if ($rows_count > 0) {
                session_start(); // Start the session
                $_SESSION['username'] = $username; // Assuming $username is defined somewhere
                echo "<script>alert('You have items in your cart')</script>";
                echo "<script>window.open('checkout.php','_self')</script>";
            } else { 
                echo "<script>window.open('../home.php','_self')</script>";
            }
        } else {
            echo "Error inserting data: " . mysqli_error($con);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo '<div id="warning-alert">Please enter all fields.</div>';
    }

    // Check if the previous part of the code executed successfully before executing this part
}
if (isset($_POST['submi'])) {
    // Retrieve form data
    $ip_ad=geIPAddress();
    $usernam = $_POST['username'];
    $passwor = $_POST['pass'];


    //itmmm
     $sql2 = "SELECT * FROM `cart_detailles` WHERE ip_adresse='$ip_ad'";
      $result2 = mysqli_query($con, $sql2);
      $num2 = mysqli_num_rows($result2);
    // Check if all fields are not empty




    if (!empty($usernam) && !empty($passwor)) {
        // Prepare SQL statement to insert data
        $sql = "select * from `userinfo` where username='$usernam' ";
        $result = mysqli_query($con, $sql);
        $fitch_data=mysqli_fetch_assoc($result);
        $num = mysqli_num_rows($result);
            if ($num > 0) {
                 $_SESSION['username'] = $usernam;
              if(password_verify($passwor,$fitch_data['password']))   {
                if($num==1 and $num2==0){
                     $_SESSION['username'] = $usernam;
                    echo "<script>alert('login successful');</script>";
                    echo "<script>window.open('../home.php','_self')</script>";

                }else {
                     $_SESSION['username'] = $usernam;
                     echo "<script>alert('login successful');</script>";
                    echo "<script>window.open('../cart.php','_self')</script>";
                }
              }
                 else {
                 echo "<script>alert('false parametre');</script>";

                }
            }
            else {
                
                  echo "<script>alert('false parametre');</script>";
                } }else {

                    echo "<script>alert('filds obgaa');</script>";
                }
            }
               

?>
  </body>
</html>