<?php 
include("../conn/conn.php");

// Récupération des catégories
$categories_query = "SELECT * FROM `categories`";
$categories_result = mysqli_query($con, $categories_query);

// Récupération des produits
$products_query = "SELECT * FROM `product_table` ORDER BY rand() LIMIT 0,20";
$products_result = mysqli_query($con, $products_query);

function geIPAddress() {  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    } else {  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
}  

function cat() {
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

//DISPLAY WHAT IN THE CART 
function contenu_cart(){
    global $con;
    $f1 = geIPAddress();
    $queryy = "SELECT * FROM `cart_detailles` WHERE ip_adresse='$f1'";
    $result = mysqli_query($con, $queryy);
    $num_prod_in_cart = mysqli_num_rows($result);
    echo $num_prod_in_cart;
}

cat();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Website</title>

    <style type="text/css">
        #warning-alert {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 10px;
            border-left: 5px solid #721c24;
        }

        #s-alert{
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            margin-bottom: 10px;
            border-left: 5px solid #28a745;
        }


        .container {
    background-color: #000; /* Black background */
    color: #fff; /* White text color */
    padding: 20px;
    border-radius: 5px;
}

.tete {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

.block, .insc {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="number"],
input[type="password"],
input[type="file"],
input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd; /* Light grey border */
    border-radius: 5px;
}

input[type="submit"] {
    background-color: #555; /* Darker grey background */
    color: #fff;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #333; /* Even darker grey on hover */
}

a {
    color: #59bfff; /* Light blue color for links */
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

    </style>
    
</head>
<body>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="container">
            <div class="tete"><b>Registration</b></div>
            <div class="block">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom"><br>
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom"><br>
                <label for="username">Username</label>
                <input type="text" name="username" id="username"><br>
                <label for="age">Age</label>
                <input type="number" name="age" id="age"><br>
                <label for="sexe">Sexe</label>
                <input type="radio" name="sexe" value="Homme"> Homme
                <input type="radio" name="sexe" value="Femme"> Femme
            </div>
            <div class="insc">
                <label for="email">Email</label>
                <input type="text" name="email" id="email"><br>
                <label for="tele">Téléphone</label>
                <input type="number" name="tele" id="tele"><br>

                <label for="adresse">Adresse</label>
                <input type="text" name="adresse" id="adresse"><br>
                <label for="pass">Password</label>
                <input type="password" name="pass" id="pass"><br>
                <label for="c_pass">Confirm Password</label>
                <input type="password" name="c_pass" id="c_pass"><br>
                <label for="img">Image</label>
                <input type="file" name="img" id="img"><br><br>
                <input type="submit" name="submit" value="Register" class="bg-info py-2 px-3 border-0" name="user_register">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </form>

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
?>

</body>
</html>
