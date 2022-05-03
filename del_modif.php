<html>

<head>
    <title>Modification des événements</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>


<?php
require('connect.php');
if (isset($_POST['idtodelete'])) {
    $id = $_POST['idtodelete'];
    $requete = $connexion->prepare("DELETE FROM event WHERE id = :id ");
    $requete->bindParam(":id", $id);
    $res = $requete->execute();
    if($res){
        echo "<h2>Evénement supprimé,vous allez être redirigés vers votre agenda.<h2>";
        header("refresh:2;url=index.php");
     }else{
         echo "une erreur s'est produite";
     }
    header("refresh:2;url=index.php");
}
if(isset($_POST['submit'])){

    $id = $_POST['submit'];
    $titre = addslashes($_POST['titre']);
    $description = addslashes($_POST['description']);
    $lieu = addslashes($_POST['lieu']);
    $datedebut = $_POST['datedebut'];
    $datefin = $_POST['datefin'];
    $heuredebut = $_POST['heuredebut'];
    $heurefin = $_POST['heurefin'];
    $query = $connexion->prepare("UPDATE event SET titre = :titre, description = :description, lieu = :lieu, datedebut = :datedebut, datefin = :datefin, heuredebut = :heuredebut, heurefin = :heurefin WHERE id = :id"); 
    $query->bindParam(":username", $username);
    $query->bindParam(":titre", $titre);
    $query->bindParam(":description", $description);
    $query->bindParam(":lieu", $lieu);
    $query->bindParam(":datedebut", $datedebut);
    $query->bindParam(":datefin", $datefin);
    $query->bindParam(":heuredebut", $heuredebut);
    $query->bindParam(":heurefin", $heurefin);
    $query->bindParam(":id", $id);

    $res = $query->execute();
    if($res){
        echo "<h2>Vos modifications ont bien été enregistrés, vous allez être redirigés vers votre agenda.<h2>";
        header("refresh:2;url=index.php");
     }else{
         echo "une erreur s'est produite";
     }
    header("refresh:2;url=index.php");
     unset($query);
}
if (isset($_POST['idtomodify'])) {
        $id = $_POST['idtomodify'];
        $query = $connexion->prepare("SELECT * FROM event WHERE id = :id");
        $query->bindParam(":id", $id);
        $res = $query->execute();
        $event = $query->fetch();
        unset($query);
?>  
    <div class="home">
    <button id="home" onclick="window.location.href = 'index.php';"><img src="icons/home.svg" /></button>
    </div>
    <h2 id="title">Espace de modification</h2>
    <br>
    <hr>
    <form method="post" action="">
        <label>Titre :</label>
        <input type="text" name="titre" id="titre" value="<?php echo $event['titre']?>" required><br>
        <label>Description :</label>
        <input type="text" name="description" id="description" value="<?php echo $event['Description']?>" required><br>
        <label>Lieu :</label>
        <input type="text" name="lieu" id="lieu"  value="<?php echo $event['Lieu']?>" required><br>
        <label>Du :</label>
        <input type="date" name="datedebut" id="datedebut" value="<?php echo $event['datedebut']?>" required>
        <label>à :</label>
        <input type="time" name="heuredebut" id="heuredebut" value="<?php echo $event['heuredebut']?>" required><br>
        <label>Au :</label>
        <input type="date" name="datefin" id="datefin" value="<?php echo $event['datefin']?>" required>
        <label>à :</label>
        <input type="time" name="heurefin" id="heurefin" value="<?php echo $event['heurefin']?>" required><br>
        <Button type="submit" name="submit" id="submit" value="<?php echo $event['id']; ?>" >Mettre à jour</button><br>
    </form>
    <?php }
?>
    </body>
    </html>