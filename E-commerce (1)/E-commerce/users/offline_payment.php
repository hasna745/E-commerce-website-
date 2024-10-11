<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement hors ligne</title>
    <link rel="stylesheet" href="../CSS/style.css"> <!-- Inclure le fichier CSS pour le style -->
    <style>
        /* Ajouter des styles supplémentaires si nécessaire */
        .return-button {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
    </style>

</head>
<body>
    <div class="container">
        <h1>Paiement hors ligne</h1>
        <p>Veuillez choisir parmi les options suivantes pour effectuer votre paiement hors ligne :</p>
        <form action="offline_payment.php" method="post">
            <input type="radio" id="rendement_magasin" name="payment_option" value="rendement_magasin">
            <label for="rendement_magasin">Rendement au magasin</label><br>
            <input type="radio" id="cash_on_delivery" name="payment_option" value="cash_on_delivery">
            <label for="cash_on_delivery">Cash on Delivery (Paiement à la livraison)</label><br>
            
            <div id="contact_info" style="display:none;">
                <label for="contact_name">Nom du contact pour la livraison :</label>
                <input type="text" id="contact_name" name="contact_name"><br>
                <label for="contact_phone">Numéro de téléphone du contact :</label>
                <input type="text" id="contact_phone" name="contact_phone"><br>
            </div>
            
            <input type="submit" value="Confirmer le paiement">
        </form>
        <p>Merci de votre commande!</p>
        <a href="../home.php" class="return-button">Retour à la page d'accueil</a>
    </div>
    
    <script>
        // JavaScript to show/hide contact info fields when "Cash on Delivery" option is selected
        document.getElementById("cash_on_delivery").addEventListener("click", function() {
            document.getElementById("contact_info").style.display = "block";
        });
        
        document.getElementById("rendement_magasin").addEventListener("click", function() {
            document.getElementById("contact_info").style.display = "none";
        });
    </script>



    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $payment_option = $_POST['payment_option'];
            echo "<p>Merci pour votre choix de paiement hors ligne.</p>";
            if ($payment_option === 'cash_on_delivery') {
                $contact_name = isset($_POST['contact_name']) ? $_POST['contact_name'] : '';
                $contact_phone = isset($_POST['contact_phone']) ? $_POST['contact_phone'] : '';
                echo "<p>Votre commande sera livrée. Le contact pour la livraison est : $contact_name ($contact_phone)</p>";
            } elseif ($payment_option === 'rendement_magasin') {
                echo "<p>Veuillez vous rendre à notre magasin pour effectuer votre paiement en personne.</p>";
            }
        } else {
            echo "<p>Aucune information de paiement n'a été soumise.</p>";
        }
        ?>
    </div>
</body>
</html>
