<html>

<head>
    <title>Personnalisation</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
<?php session_start();
    require('connect.php');
    if (!isset($_SESSION['username'])) {
    	header("refresh:0;url=index.php");
    }
    $requete = $connexion->prepare("SELECT * FROM utilisateurs WHERE username=?");
    $requete->execute([$_SESSION['username']]);
    $pref = $requete->fetch();
  	$samedi = $pref['couleur_sam'];
  	$dimanche = $pref['couleur_dim'];
  	$ferie = $pref['ferie'];
  	$pont = $pref['couleur_ponts'];
  	$nbre_j_affichage = $pref['nbre_j_affichage'];
  	$onclickevent = $pref['onclickevent'];

    if (isset($_POST['majcouleurs'])){
        $username = $_SESSION['username'];
        $sam = $_POST['sam'];
        $dim = $_POST['dim'];
        $ponts = $_POST['ponts'];
        $ferie = $_POST['ferie'];
        $colorclick = $_POST['onclickevent'];
        $nbre_j_affichage = $_POST['nbre_j_affichage'];
        $requete = $connexion->prepare(
            "UPDATE utilisateurs SET 
                couleur_sam = :sam,
                couleur_dim = :dim,
                ferie = :ferie,
                nbre_j_affichage = :nbre_j_affichage,
                onclickevent = :onclickevent,
                couleur_ponts = :ponts 
                WHERE username = '$username'
            ");
        $requete->bindParam(":sam", $sam);
        $requete->bindParam(":dim", $dim);
        $requete->bindParam(":ferie", $ferie);
        $requete->bindParam(":nbre_j_affichage", $nbre_j_affichage);
        $requete->bindParam(":onclickevent", $colorclick);
        $requete->bindParam(":ponts", $ponts);
        $res = $requete->execute();
      if($res){
         echo "Paramètres mis à jours !";
         header("refresh:2;url=index.php");
      }else{
          echo "une erreur s'est produite";
      }
    }else {?>
    <div class="home">
	<button id="home" onclick="window.location.href='index.php';"><img src="icons/home.svg"/></button>
</div>
<h2 id="title">Espace de personnalisation</h2>
<br>
<hr>
<div id="settings">
	<form method="post" action="">
		<table id="settingstable">
		<tr>
			<td>
				Couleur colonne samedi :
			</td>
			<td>
				<input type="color" id="sam" name="sam" value="<?php echo $samedi;?>" required>
			</td>
		</tr>
		<tr>
			<td>
				Couleur colonne dimanche :
			</td>
			<td>
				<input type="color" id="dim" name="dim" value="<?php echo $dimanche;?>" required>
			</td>
		</tr>
		<tr>
			<td>
				Couleur jour férié :
			</td>
			<td>
				<input type="color" id="ferie" name="ferie" value="<?php echo $ferie;?>" required>
			</td>
		</tr>
		<tr>
			<td>
				Couleur jour click :
			</td>
			<td>
				<input type="color" id="onclickevent" name="onclickevent" value="<?php echo $onclickevent;?>" required>
			</td>
		</tr>
		<tr>
			<td>
				Couleur des ponts possibles :
			</td>
			<td>
				<input type="color" id="ponts" name="ponts" value="<?php echo $pont;?>" required>
			</td>
		</tr>
		<tr>
			<td>
				Nombre de jours à afficher :
			</td>
			<td>
				<input type="text" id="nbre_j_affichage" name="nbre_j_affichage" value="<?php echo $nbre_j_affichage;?>" size="4" required>
				<td>
				</tr>
				</table>
				<input type="submit" id="majcouleurs" name="majcouleurs" value="Mettre à jour les paramètres">
			</form>
		</div>
		<?php }
    ?>
		</body>
		</html>