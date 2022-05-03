<html>

<head>
    <title>Calendrier</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
<?php 
require('connect.php');
if(isset($_POST['reset_passwd'])){
    $username = $_POST['reset_passwd'];
    $password = hash('sha256', $_POST['password']);
    $query = $connexion->prepare("UPDATE utilisateurs SET password = :password, rdm_passwd= 0 WHERE username = '$username'"); 
    $query->bindParam(":password", $password);
    $res = $query->execute();
    if($res){
        echo "Personnalisation du mot de passe réalisée avec succès !";
        header("refresh:2;url=index.php");
     }else{
       echo "erreur";
     }
     unset($query);
}elseif (isset($_POST['connexion'])){
    $password = hash('sha256', $_POST['password']);
    $username = $_POST['username'];
    $requete = $connexion->prepare("SELECT * FROM utilisateurs WHERE username = :username AND password = :password");
    $requete->bindParam(":username", $username);
    $requete->bindParam(":password", $password);
    $requete->execute();
    $user = $requete->fetch();
    if($user){
        if(($user['rdm_passwd']) == 1) {?>
            <h2 id="title">Connexion après réinitialisation du mot de passe</h2>
            <br>
            <hr>
            <p>Heureux de vous revoir <?php echo $username ?> !</p>
            <p>Un mot de passe temporaire vous a permis de vous reconnecter à votre compte, cependant veuillez personnaliser à nouveau votre mot de passe grâce au formulaire mis à votre disposition ci-dessous.<p>
            <form method="post" action="">
            <b> Nouveau mot de passe : </b>
            <input type="password" name="password" placeholder="Mot de passe" required />    
            <Button type="submit" name="reset_passwd" id="reset_passwd" value="<?php echo $username; ?>" >Personnaliser le mot de passe</button><br>
            </form>
            <?php 
            unset($requete);
            return;
        }
        session_start();
        $_SESSION['username'] = $username;
        header("refresh:0;url=index.php");
    }else{
        echo "erreur dans le nom d'utilisateur ou mot de passe";
    }
} 

    ?>
</body>
</html>


