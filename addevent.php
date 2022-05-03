<html>

<head>
    <title>Calendrier</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>

<?php
    session_start();
    require('connect.php');
    if (isset($_POST['submit'])){
        $username = $_SESSION['username'];
        $titre = addslashes($_POST['titre']);
        $description = addslashes($_POST['description']);
        $lieu = addslashes($_POST['lieu']);
        $datedebut = $_POST['datedebut'];
        $datefin = $_POST['datedebut'];
        $heuredebut = $_POST['heuredebut'];
        $heurefin = $_POST['heurefin'];
    
    $query = $connexion->prepare("INSERT INTO `event` VALUES ('', :username, :titre, :description, :lieu, :datedebut, :datefin, :heuredebut, :heurefin)");
    $query->bindParam(":username", $username);
    $query->bindParam(":titre", $titre);
    $query->bindParam(":description", $description);
    $query->bindParam(":lieu", $lieu);
    $query->bindParam(":datedebut", $datedebut);
    $query->bindParam(":datefin", $datefin);
    $query->bindParam(":heuredebut", $heuredebut);
    $query->bindParam(":heurefin", $heurefin);

    $res = $query->execute();
      if($res){
         echo "<h2>Nouvel événement enregistré, vous allez être redirigé vers votre agenda.<h2>";
         header("refresh:2;url=index.php");
      }else{
          echo "une erreur s'est produite";
      }
    }
?>

</body>
</html>