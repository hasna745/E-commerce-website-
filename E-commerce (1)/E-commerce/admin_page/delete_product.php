<?php
include('../conn/conn.php');

if(isset($_GET['id'])) {
    $prod_id = $_GET['id'];

    $query = "DELETE FROM `product_table` WHERE id_prod = $prod_id";

    $result = mysqli_query($con, $query);

    if($result) {
         header("Location: view_product.php");
        exit();
    } else {
        header("Location: index.php?delete_error=true");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
