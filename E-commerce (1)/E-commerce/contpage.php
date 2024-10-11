<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
    <h1>Welcome to ESTITICACASA</h1>
    <p>Experience our passion for floral art and the elegance of each vase.</p>
    <p>Your satisfaction is our top priority. Share your feedback or suggestions with us with love by filling out the form below.</p>
</header>


    <main>
        <section id="contact">
            <div class="contact-form" style="display: flex; align-items: flex-start;">
                <div style="flex: 1;">
                    <h2 style="text-align: left; margin-bottom: 20px;">Send a Message</h2>
                    <form id="contactForm" action="#" method="POST">
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <label for="fullName">Full Name</label>
                            <input type="text" id="fullName" name="fullName" required>
                            
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required>
                            
                            <label for="orderRef">Order Reference (optional)</label>
                            <input type="text" id="orderRef" name="orderRef">
                            
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" style="margin-top: 20px;">Send a Message</button>
                    </form>
                </div>
                <!-- Add additional content here if necessary -->
            </div>
        </section>


        <section id="map">
            <h2>Our Locations</h2>
            <div id="googleMap" style="height: 300px; width: 100%; overflow: hidden;">
                <!-- Integrate Google Maps here -->
                <iframe width="100%" height="100%" frameborder="0" style="border:0" src="https://www.google.com/maps?q=103+Boulevard+Omar+El+Khayam+Beaus%C3%A9jour,+Casablanca,+Maroc&output=embed" allowfullscreen></iframe>
            </div>
        </section>

        <div style="display: flex; gap: 20px; margin-top: 20px;">
            <section id="livraison-rapide">
                <div><i class="fa fa-shipping-fast delivery-icon"></i></div>
                <h2>Fast Delivery</h2>
                <p>Delivery with Love and Care: Each vase is delivered with a touch of love and care so that you receive an exceptional product.</p>
            </section>

            <section id="points-fidelite-parrainage">
                <div><i class="fa fa-gift points-icon"></i></div>
                <h2>Loyalty Points and Referral</h2>
                <p>For every purchase, you earn loyalty points that can be converted into a voucher on your next order. Share our site with your friends and enjoy a GIFT.</p>
            </section>

            <section id="vase">
                <div><i class="fa fa-flower"></i></div>
                <h2>Minimalist and Chic Style Vase</h2>
                <p>We carefully select the most elegant and durable vases, collaborating closely with renowned potters to ensure quality and aesthetics.</p>
            </section>
        </div>

    </main>

    <footer>
        <div class="contact-info">
            <h2>Contact Us</h2>
            <p style="text-align: center;">If you have any questions or comments, feel free to contact us using the form below.</p>
            <ul>
                <li><i class="fa fa-phone"></i><strong>Phone:</strong> +212 6 07 54 91 07</li>
                <li><i class="fa fa-fax"></i><strong>Fax:</strong> +212 5 22 99 09 35</li>
                <li><i class="fa fa-at"></i><strong>Email:</strong> Contact@estiticacsa.com</li>
                <li><i class="fa fa-instagram"></i><strong>Instagram:</strong> <a href="https://www.instagram.com/estiticacasa?utm_source=qr&igsh=eDcyN3UyYnduZXpt" target="_blank">@estiticacasa</a></li>
            </ul>
        </div>
        <p>&copy; 2024 Estiticacasa - Site created by <a href="#">HASNA ZOUHRI MERYEM LACHGAR FATIMA EZZAHRA RAJI</a></p>
    </footer>

</body>

</html>