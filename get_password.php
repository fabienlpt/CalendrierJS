<html>

<head>
    <title>Récupération mot de passe</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
<div class="home">
    <button id="home" onclick="window.location.href = 'index.php';"><img src="icons/home.svg"/></button>
</div>
    <h2 id="title">Mot de passe oublié</h2>
    <br>
    <hr>
<?php 
require('connect.php');
if (isset($_POST['get_passwd'])){
    $dest = $_POST['email'];
    $query = $connexion->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $query->bindParam(":email", $dest);
    $query->execute();
    $dest_exists = $query->fetch();
    if($dest_exists){
        $letters_numbers = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $shuffle = str_shuffle($letters_numbers);
        $pwd = substr($shuffle,0,8);
        $sujet = "[NE PAS REPONDRE] - Récupération de mot de passe Calendrier intéractif ";
        $texte = "Ci-joint vous trouverez votre mot de passe temporaire. Une fois de nouveau connecté, veuillez le personnaliser. Mot de passe temporaire : " . $pwd;
        $headers = "From : validati0n.3mail@gmail.com";
        if (mail($dest, $sujet, $texte, $headers)) {
            echo "Email envoyé avec succès à $dest";
            $pwd = hash('sha256',$pwd);
            $query = $connexion->prepare("UPDATE utilisateurs SET password='$pwd', rdm_passwd= '1' WHERE email = :email"); 
            $query->bindParam(":email", $dest);
            $query->execute();
        } else {
            echo "Échec lors de l'envoi";
        }   
    }else{
        echo "Cet email ne correspond à aucun compte";
        header("refresh:1;url=get_password.php");
    } 
    
} else {?>
    <p>Bienvenu dans l'espace de récupération du mot de passe, après avoir rentré votre email vous recevrez un email contenant un mot de passe provisoire.</p>
<form method="post" action="">
    <b>Email utilisé : <b>
    <input type="email" name="email" id="email">
    <input type="submit" id="get_passwd" name="get_passwd" value="Envoyer le mail de récupération">
</form>
<?php }?>
</body>
</html>


