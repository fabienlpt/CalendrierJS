<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contact</title>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
<div class="home">
    <button id="home" onclick="window.location.href = 'index.php';"><img src="icons/home.svg" /></button>
    </div>
    <h2 id="title">Formulaire de contact</h2>
    <br>
    <hr>
    <form id="contact" method="post">
        <label>Email (obligatoire) :</label><br>
        <input type="email" name="email" required><br>
        <label>Objet :</label><br>
        <input type="text" name="objet" required><br>
        <label>Message :</label><br>
        <textarea rows="10" cols="100" name="message" required></textarea><br>
        <input type="submit" value="Envoyer">
    </form>
    <?php
    if (isset($_POST['message'])) {
        $sujet = $_POST['objet'];
        $texte = $_POST['message'];
        $email = $_POST['email'];
        $headers = "From: ". $email . "\n" .
                    "Reply-To: ". $email;
        $dest = "validati0n.3mail@gmail.com";
        if (mail($dest, $sujet, $texte, $headers)) {
            echo "Email envoyé avec succès, nous vous recontacterons dans les plus brefs délais.";
        } else {
            echo "Échec lors de l'envoi";
         }   
    }
    ?>
</body>
</html>