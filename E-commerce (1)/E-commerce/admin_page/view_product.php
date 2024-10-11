<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" type="text/css" href="../CSS/css.css">
    <link rel="stylesheet" type="text/css" href="../CSS/css-img.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    /* Table styles */
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    .table th,
    .table td {
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }
    .table th {
        background-color: #f2f2f2;
    }
    /* Image styles */
    .image img {
        max-width: 100px;
        height: auto;
        display: block;
        margin: 0 auto;
    }
    /* Centering text in the last column */
    .table td:last-child {
        text-align: center;
    }
</style>
</head>
<body>
    <?php
    // Include the file where the database connection is established
    include('../conn/conn.php');

    // Fetch products from the database
    $query = "SELECT * FROM `product_table`";
    $result = mysqli_query($con, $query);

    // Check if the query was successful
    if ($result) {
    ?>
    <div class="container">
        <div class="row">
            <form action="" method="post">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Title</th>
                            <th>Product Image</th>
                            <th>Product Price</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop through the fetched products
                        while ($row = mysqli_fetch_array($result)) {
                            $prod_id = $row['id_prod'];
                            $prod_title = $row['procduct_name'];
                            $prod_image = $row['procduct_image1'];
                            $prod_price = $row['procduct_price'];
                        ?>
                        <tr>
                            <td><?php echo $prod_id; ?></td>
                            <td><?php echo $prod_title; ?></td>
                            <td class="image"><img src="product_images/<?php echo $prod_image; ?>" alt="Product Image"></td>
                            <td><?php echo $prod_price; ?></td>
                            <td>
                                <a href="moi.php?id=<?php echo $prod_id; ?>" onclick="return confirm('Are you sure you want to update this product?');">
                                    <i class="fas fa-edit"></i> Edit Product
                                </a>
                            </td>
                            <td>
                                <a href="delete_product.php?id=<?php echo $prod_id; ?>" onclick="return confirm('Are you sure you want to delete this product?');">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <?php
    } else {
        // Display an error message if the query fails
        echo "Error executing query: " . mysqli_error($con);
    }
    ?>
</body>
</html>
