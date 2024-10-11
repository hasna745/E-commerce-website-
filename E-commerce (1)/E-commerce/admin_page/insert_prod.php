<?php 
include("../conn/conn.php");

if(isset($_POST['insert_prro'])) {
    // Récupération des données du formulaire
    $prod_title = mysqli_real_escape_string($con, $_POST['title']);
    $prod_descr = mysqli_real_escape_string($con, $_POST['prod-des']);
    $prod_key = mysqli_real_escape_string($con, $_POST['keywords']);
    $prod_cate = mysqli_real_escape_string($con, $_POST['prod_cate']);
    $prod_price = mysqli_real_escape_string($con, $_POST['prod-price']);
    $prod_status = 'true';
    $prod_quans = mysqli_real_escape_string($con, $_POST['prod-quas']);  
    $prod_delevry = mysqli_real_escape_string($con, $_POST['prod-delevry']);
    $prod_more_info = mysqli_real_escape_string($con, $_POST['prod-more-info']);

    // Récupération des noms de fichiers d'images
    $img1 = $_FILES['img1']['name'];
    $img2 = $_FILES['img2']['name'];
    $img3 = $_FILES['img3']['name'];

    // Récupération des fichiers images temporaires
    $img11 = $_FILES['img1']['tmp_name'];
    $img22 = $_FILES['img2']['tmp_name'];
    $img33 = $_FILES['img3']['tmp_name'];

    // Vérification des champs vides
    if(empty($prod_title) || empty($prod_descr) || empty($prod_cate) || empty($prod_price) || empty($img1) || empty($img2) || empty($img3)) {
        echo "<script>alert('Veuillez remplir tous les champs disponibles')</script>"; 
    } else {
        // Déplacement des images téléchargées vers le répertoire de destination
        move_uploaded_file($img11, "./product_images/$img1");
        move_uploaded_file($img22, "./product_images/$img2");
        move_uploaded_file($img33, "./product_images/$img3");

        // Préparation de la requête d'insertion
        $insert_pro = "INSERT INTO `product_table` (procduct_name, procduct_des, procduct_keyw, id_cat, procduct_image1, procduct_image2, procduct_image3, procduct_price, date, status, quan_stock, delivery_info, common_details,country) 
                VALUES ('$prod_title', '$prod_descr', '$prod_key', '$prod_cate', '$img1', '$img2', '$img3', '$prod_price', NOW(), '$prod_status', '$prod_quans', '$prod_delevry', '$prod_more_info','morocco')";

        // Exécution de la requête d'insertion
        $result = mysqli_query($con, $insert_pro);

        // Vérification de l'insertion
        if($result) {
            echo "<script>alert('Produit inséré avec succès')</script>";

             header("Location: index.php");
        exit();
        } else {
            echo "Erreur lors de l'insertion du produit";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
<style type="text/css">
  
  /* Form Container */
.form-container {
  max-width: 500px;
  margin: 0 auto;
  padding: 30px;
  background-color: #f9f9f9;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Labels */
.form-label {
  display: block;
  font-size: 16px;
  margin-bottom: 8px;
  color: #333;
}

/* Text Inputs */
.form-input {
  width: 100%;
  padding: 12px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
  color: #555;
}

/* Select */
.form-select {
  width: 100%;
  padding: 12px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
  color: #555;
  background-color: #fff;
}

/* Submit Button */
.form-submit {
  background-color: #4CAF50;
  color: #fff;
  padding: 15px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s;
}

.form-submit:hover {
  background-color: #45a049;
}

/* File Input Label */
.form-file-label {
  display: block;
  margin-bottom: 8px;
  font-size: 16px;
  color: #333;
}

/* File Input */
.form-file-input {
  display: none;
}

/* File Input Styling */
.form-file-label::before {
  content: 'Upload Image';
  display: inline-block;
  background-color: #4CAF50;
  color: #fff;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
}

/* File Input Styling - Hover */
.form-file-label:hover::before {
  background-color: #45a049;
}

</style>
</head>
<body>
  <form action="" method="post" enctype="multipart/form-data" class="form-container">
    <label for="title" class="form-label">Product Title</label><br>
    <input type="text" name="title" id="title" placeholder="Enter product title" required="required" class="form-input"><br>
    
    <label for="prod-des" class="form-label">Product Description</label><br>
    <input type="text" name="prod-des" id="prod-des" placeholder="Enter product description" required="required" class="form-input"><br>
    
    <label for="keywords" class="form-label">Product Keywords</label><br>
    <input type="text" name="keywords" id="keywords" placeholder="Enter product keywords" class="form-input"><br>
    
    <h3>Product Categories</h3><br>

   <select name="prod_cate" class="form-select">
    <?php  
    $select_cat = "SELECT * FROM `Categories`";
    $result_cat = mysqli_query($con, $select_cat);
    while ($row = mysqli_fetch_assoc($result_cat)) {
        $Category_id = $row['id_cat'];
        $Category_name = $row['nom_cat'];
        echo "<option value='$Category_id'>$Category_name</option>";


    }
    ?> 
</select><br>

    
    <label for="img1" class="form-file-label">Product Image 1</label><br>
    <input type="file" name="img1" id="img1" class="form-file-input"><br>
    
    <label for="img2" class="form-file-label">Product Image 2</label><br>
    <input type="file" name="img2" id="img2" class="form-file-input"><br>
    
    <label for="img3" class="form-file-label">Product Image 3</label><br>
    <input type="file" name="img3" id="img3" class="form-file-input"><br>
    
    <label for="prod-price" class="form-label">Product Price</label><br>
    <input type="number" name="prod-price" id="prod-price2" placeholder="Enter product price" class="form-input"><br>
    <label for="prod-quas" class="form-label">qualite of stock</label><br>
    <input type="number" name="prod-quas" id="prod-quas" placeholder="Enter product quantite of stock" class="form-input"><br>
    <label for="prod-delevry" class="form-label">delivery information</label><br>
    <input type="text" name="prod-delevry" id="prod-delevry" placeholder="Enter product delivery information" class="form-input"><br>
        <label for="prod-more-info"  class="form-label">common_details</label><br />
    <textarea name="prod-more-info" id="prod-more-info"
    rows="10" cols="50"  placeholder="Enter product more detailles" class="form-input"></textarea>
    <br>
    <input type="submit" name="insert_prro" value="Insert Product" class="form-submit">  
</form>



</body>
</html>