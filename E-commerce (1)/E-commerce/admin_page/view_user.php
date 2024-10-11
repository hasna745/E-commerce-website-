

<?php
include("../conn/conn.php");

// Fetch user data from the database
$select_users_query = "SELECT * FROM `userinfo`";
$users_result = mysqli_query($con, $select_users_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
     <link rel="stylesheet" type="text/css" href="../CSS/css.css">
    <link rel="stylesheet" type="text/css" href="../CSS/css-img.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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


    <h2>Registered Users</h2> </br>


<br>
</br>
</br>

    <div class="container">
    <div class="row">
        <table class="table table-bordered">
            <thead>
                <tr>
            <th>Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Age</th>
            <th>Sexe</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Address</th>
            
        </tr>
            </thead>
            <tbody>
               <?php
        // Loop through each user and display their details
        while ($user = mysqli_fetch_assoc($users_result)) {
            echo "<tr>";
            echo "<td>".$user['nom']."</td>";
            echo "<td>".$user['prenom']."</td>";
            echo "<td>".$user['username']."</td>";
            echo "<td>".$user['age']."</td>";
            echo "<td>".$user['sexe']."</td>";
            echo "<td>".$user['email']."</td>";
            echo "<td>".$user['tele']."</td>";
            echo "<td>".$user['adresse']."</td>";
            // You can include more fields here as needed
            echo "</tr>";
        }
        ?>
            </tbody>
        </table>
    </div>
</div>

    
</body>
</html>
