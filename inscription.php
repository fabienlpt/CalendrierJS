<!DOCTYPE html>
<html>
    <head>
        <title>Inscription</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/style.css" />
    </head>
<body>
<div class="home">
    <button id="home" onclick="window.location.href = 'index.php';"><img src="icons/home.svg" /></button>
</div>
    <h1 id="title">Inscription</h1>
    <br>
    <hr>
<?php
require('connect.php');
if (isset($_POST['submit'])){
  // stock le nom d'utilisateur
  $username = $_POST['username'];
  //crypte  puis stock le MDP
  $password = hash('sha256', $_POST['password']);
  $mail = $_POST['mail'];
  $query = $connexion->prepare("SELECT * FROM utilisateurs WHERE email = :mail");
  $query->bindParam(":mail", $mail);
  $query->execute();
  $user = $query->fetch();
    if($user){
      header("refresh:2;url=inscription.php");
      exit("Cet adresse mail est déjà associée à un compte.");
    }
  $query = $connexion->prepare("SELECT * FROM utilisateurs WHERE username = :username");
  $query->bindParam(":username", $username);
  $query->execute();
  $user = $query->fetch();
    if($user){
      header("refresh:2;url=inscription.php");
      exit("Ce nom d'utilisateur existe déjà");
    }
  $query = $connexion->prepare("INSERT INTO `utilisateurs` VALUES ('', :username, :password, '', '', '', '','','', :mail, 0 )");
  $query->bindParam(":username", $username);
  $query->bindParam(":password", $password);
  $query->bindParam(":mail", $mail);
  $res = $query->execute();
    if($res){
       echo "Incription réalisée avec succès, bienvenue ".$username." !";
       header("refresh:2;url=index.php");
    }else{
      echo "erreur";
    }
?>
<?php }else{ ?>
  <div id="subscribe">
  <form action="" method="post">
  <b>Nom d'utilisateur : </b>
  <input type="text" name="username" placeholder="Nom d'utilisateur" required /><br>
  <b>Email : </b>
  <input type="email" name="mail" placeholder="Email" required /><br>
  <b> Mot de passe : </b>
  <input type="password" name="password" placeholder="Mot de passe" required />
  
    <input type="submit" name="submit" value="S'inscrire"/>
</form>
  </div>
<?php } ?>
</body>
</html>