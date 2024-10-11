<?php 
include("../conn/conn.php");

if(isset($_GET['id'])) {
    $prod_id = mysqli_real_escape_string($con, $_GET['id']);

    $query = "SELECT * FROM `product_table` WHERE id_prod = '$prod_id'";
    $result = mysqli_query($con, $query);

    if($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        if(isset($_POST['update_product'])) {
            $prod_title = mysqli_real_escape_string($con, $_POST['title']);
            $prod_descr = mysqli_real_escape_string($con, $_POST['prod-des']);
            $prod_key = mysqli_real_escape_string($con, $_POST['keywords']);
            $prod_cate = mysqli_real_escape_string($con, $_POST['prod_cate']);
            $prod_price = mysqli_real_escape_string($con, $_POST['prod-price']);
            $prod_status = mysqli_real_escape_string($con, $_POST['prod-status']);
            $prod_quans = mysqli_real_escape_string($con, $_POST['prod-quas']);
            $prod_delevry = mysqli_real_escape_string($con, $_POST['prod-delevry']);
            $prod_more_info = mysqli_real_escape_string($con, $_POST['prod-more-info']);

            // Ajoutez les autres champs à mettre à jour ici

            $update_query = "UPDATE `product_table` SET procduct_name = '$prod_title', procduct_des = '$prod_descr', procduct_keyw = '$prod_key', id_cat = '$prod_cate', procduct_price = '$prod_price', status = '$prod_status', quan_stock = '$prod_quans', delivery_info = '$prod_delevry', common_details = '$prod_more_info' WHERE id_prod = '$prod_id'";
            $update_result = mysqli_query($con, $update_query);

            if($update_result) {
                echo "<script>alert('Produit mis à jour avec succès')</script>";
            } else {
                echo "Erreur lors de la mise à jour du produit";
            }
        }
    } else {
        echo "Aucun produit trouvé avec cet identifiant";
    }
} else {
    echo "Identifiant du produit non spécifié";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
     <style type="text/css">
        /* Form Container */
        .form-container {
            max-width: 500px;
            margin: 50px auto;
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
    </style>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data" class="form-container">
        <label for="title" class="form-label">Product Title</label><br>
        <input type="text" name="title" id="title" placeholder="Enter product title" value="<?php echo isset($product['procduct_name']) ? $product['procduct_name'] : ''; ?>" required="required" class="form-input"><br>
        
        <label for="prod-des" class="form-label">Product Description</label><br>
        <input type="text" name="prod-des" id="prod-des" placeholder="Enter product description" value="<?php echo isset($product['procduct_des']) ? $product['procduct_des'] : ''; ?>" required="required" class="form-input"><br>
        
        <label for="keywords" class="form-label">Product Keywords</label><br>
        <input type="text" name="keywords" id="keywords" placeholder="Enter product keywords" value="<?php echo isset($product['procduct_keyw']) ? $product['procduct_keyw'] : ''; ?>" class="form-input"><br>

        <h3>Product Categories</h3><br>

        <select name="prod_cate" class="form-select">
            <?php  
            $select_cat = "SELECT * FROM `Categories`";
            $result_cat = mysqli_query($con, $select_cat);
            while ($row = mysqli_fetch_assoc($result_cat)) {
                $Category_id = $row['id_cat'];
                $Category_name = $row['nom_cat'];
                $selected = ($Category_id == $product['id_cat']) ? 'selected' : '';
                echo "<option value='$Category_id' $selected>$Category_name</option>";
       
            }
            ?> 
        </select><br>

        <label for="prod-price" class="form-label">Product Price</label><br>
        <input type="number" name="prod-price" id="prod-price2" placeholder="Enter product price" value="<?php echo isset($product['procduct_price']) ? $product['procduct_price'] : ''; ?>" class="form-input"><br>

        <label for="prod-status" class="form-label">Product Status</label><br>
        <select name="prod-status" class="form-select">
            <option value="true" <?php if(isset($product['status']) && $product['status'] == 'true') echo 'selected'; ?>>True</option>
            <option value="false" <?php if(isset($product['status']) && $product['status'] == 'false') echo 'selected'; ?>>False</option>
        </select><br>

        <label for="prod-quas" class="form-label">Qualite of Stock</label><br>
        <input type="number" name="prod-quas" id="prod-quas" placeholder="Enter product quantity of stock" value="<?php echo isset($product['quan_stock']) ? $product['quan_stock'] : ''; ?>" class="form-input"><br>

        <label for="prod-delevry" class="form-label">Delivery Information</label><br>
        <input type="text" name="prod-delevry" id="prod-delevry" placeholder="Enter product delivery information" value="<?php echo isset($product['delivery_info']) ? $product['delivery_info'] : ''; ?>" class="form-input"><br>

        <label for="prod-more-info" class="form-label">Common Details</label><br />
        <textarea name="prod-more-info" id="prod-more-info" rows="10" cols="50" placeholder="Enter product more details" class="form-input"><?php echo isset($product['common_details']) ? $product['common_details'] : ''; ?></textarea>
        <br>

        <input type="submit" name="update_product" value="Update Product" class="form-submit">    
    </form>
</body>
</html>
