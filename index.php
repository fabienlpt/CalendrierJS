<html>

<head>
    <meta charset="utf-8" />
    <title>Calendrier</title>
    <html lang="fr">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javaScript" src="js/calendrier.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" content-type="text/css" href="css/style.css" />
</head>

<body>
    <?php
    session_start();
    if(!isset($_SESSION['username'])){; ?>
        <div id="connection">
        <form action="check.php" method="POST">
        <b>Connexion :</b>
        <b>Nom d'utilisateur</b>
        <input type="text" placeholder="nom d'utilisateur" name="username" required>
        <b>Mot de passe</b>
        <input type="password" placeholder= "mot de passe" name="password" required>
        <input type="submit" id="connexion" name="connexion" placeholdervalue="Connexion" >
        </form>
        &nbsp;
        <a href="get_password.php" > Mot de passe oublié</a>
        &nbsp;
        <a href="inscription.php" > Inscription</a>
        </div>
        <?php
     }else {?>
    <div id="connected">
    <p>Vous êtes connecté en tant que <b> <?php echo $_SESSION['username']; ?> </b>
    <button onclick="window.location.href ='parametres.php'" >Paramètres</button>
     <button onclick="window.location.href ='deconnexion.php'" >Se déconnecter</button>
     </div>
     <?php }
     ?>

    <div id="HL"></div>
    <script src="js/horloge.js"></script>
    <div id="calendrier">
    <div id="current">                              
        <input type=button value="<<" onClick="--m; if (m == -1) { m = 11; a = a - 1;} complete_calendar(m,a)" /> 
        <b id="monthyear"></b>   
        <input type=button value=">>" onClick="++m; if (m == 12) { m = 0; a = a + 1;} complete_calendar(m,a)" />
    </div>

    <br>
    <div id="othermonth">
        <select name="month" id="month" onchange="m = parseInt(document.getElementById('month').value); complete_calendar(m,a)">
            <option value="0">Janvier</option>
            <option value="1">Février</option>
            <option value="2">Mars</option>
            <option value="3">Avril</option>
            <option value="4">Mai</option>
            <option value="5">Juin</option>
            <option value="6">Juillet</option>
            <option value="7">Aout</option>
            <option value="8">Septembre</option>
            <option value="9">Octobre</option>
            <option value="10">Novembre</option>
            <option value="11">Décembre</option>
        </select>
        <form onsubmit="a = parseInt(document.getElementById('year').value); complete_calendar(m,a); return false">
            <input id = "year" type="texte" maxlength="4" placeholder="Année"></input>
        </form>
    </div>

    <table id="calendar">
    </table>
    </div>
    
    <?php
    require('connect.php');
    if(isset($_SESSION['username'])){;?>
    <div id="event">
        <div id ="click"></div>
        <div id="addevent">
            <h3>Ajouter un événement</h3>
        
            <form method="post" action="addevent.php">
                <label>Titre :</label>
                <input type="text" name="titre" id="titre" required><br>
                <label>Description :</label>
                <input type="text" name="description" id="description" required><br>
                <label>Lieu :</label>
                <input type="text" name="lieu" id="lieu" required><br>
                <label>Du :</label>
                <input type="date" name="datedebut" id="datedebut" value="" required>
                <label>à :</label>
                <input type="time" name="heuredebut" id="heuredebut" required><br>
                <label>Au :</label>
                <input type="date" name="datefin" id="datefin" required>
                <label>à :</label>
                <input type="time" name="heurefin" id="heurefin" required><br>
                <input type="submit" name="submit" id="submit" value="Enregistrer" ><br>
            </form>
        </div>
    </div>
    <div id="nextevent">
        <h2>Mes prochains événements</h2>
        <?php
        $username = $_SESSION['username'];
        $query = $connexion->prepare("SELECT * FROM utilisateurs WHERE username = '$username'");
        $query->execute();
        $user = $query->fetch();
        $todaydate = date("Y-m-d");
        if($user['nbre_j_affichage'] == null){
            $maxday = intval(date('d') + 5);
        }else{
            $maxday = intval(date('d') + $user['6']);
        }
        $month = intval(date('m'));
        $year = intval(date('Y'));
        $date2 = (new DateTime("$year-$month-$maxday"))->format('Y-m-d');
        $requete = $connexion->prepare("SELECT * FROM event WHERE username = '$username' ORDER BY datedebut");
        $requete->execute();
        while($event = $requete->fetch()){
            if($event['datedebut'] >= $todaydate && $event['datedebut'] <= $date2){
            ?>
            <ul>
             <li><b><?php echo $event['titre']?></b> le <b><?php echo $event['datedebut']?></b> de <b><?php echo $event['heuredebut']?></b> à <b><?php echo $event['heurefin']?></b></li>
             <details><summary>Détails</summary>
            Description : <?php echo $event['Description']?> <br>
            Lieu : <a href="https://www.google.com/maps/place/<?php echo $event['Lieu']?>"> <?php echo $event['Lieu']?> </a><br>
            </details>
            </ul>
            <form method="post" action="del_modif.php">
            <button type="submit" name="idtodelete" value="<?php echo $event['id']; ?>">Supprimer</button>
            <button type="submit" name="idtomodify" value="<?php echo $event['id']; ?>">Modifier</button>
            </form>
           <?php }
        } 
        ?>
    </div>
    <?php 

} ?>
    <script type="text/javaScript">
        var date = new Date;
        var m = date.getMonth();
        var a = date.getFullYear();
        <?php if(isset($_SESSION['username'])){?>

        function clickEvent(id){
            complete_calendar(m,a);
            var x = document.getElementById('day-' + id).innerHTML;
            if(x == ""){
                return;
            }
        <?php 
            $username = $_SESSION['username'];
            $requete = $connexion->prepare("SELECT * FROM utilisateurs WHERE username = '$username'");
            $requete->execute();
            while($colorclick = $requete->fetch()){
                if($colorclick['onclickevent'] != null){ ?>
                    colorize(id, '<?php echo $colorclick['onclickevent']; ?>' );
                    document.getElementById('day-' + id).style.textDecoration = "underline";
            <?php }else { ?>
                    colorize(id,'orange');
                    document.getElementById('day-' + id).style.textDecoration = "underline";
            <?php }
            }
            ?>
            var month = m + 1;
            

            if( x < 10){ 
                x = '0' + x;
            }

            document.getElementById('datedebut').value = a + "-" +  month + "-" + x;
            document.getElementById('datefin').value = a + "-" +  month + "-" + x;
            const date = String(a + '-' + month + '-' + x); 
            document.getElementById('click').innerHTML = "<h2> Evénement du : " + x + '/' + month + '/' + a + "</h2>";
            <?php
            $requete = $connexion->prepare("SELECT * FROM event WHERE username = '$username'");
            $requete->execute();
            while($event = $requete->fetch()){?>
            var testdate = "<?php echo $event['datedebut'] ?>";

                if(date == testdate){
                    document.getElementById('click').innerHTML += "<ul> " +
             "<li><b><?php echo $event['titre']?></b> de <b><?php echo $event['heuredebut']?></b> à <b><?php echo $event['heurefin']?></b></li>" +
             "<details><summary>Détails</summary>Description : <?php echo $event['Description']?> <br>" +
            "Lieu : <a href='https://www.google.com/maps/place/<?php echo $event['Lieu']?>'> <?php echo $event['Lieu']?> </a><br></details>" +
           " </ul> " +
            "<form method='post' action='del_modif.php'>" +
            "<button type='submit' name='idtodelete' value='<?php echo $event['id']; ?>'>Supprimer</button>" +
            "<button type='submit' name='idtomodify' value='<?php echo $event['id']; ?>'>Modifier</button>" +
            "</form>" 
            }
           <?php 
            } ?>
            }
            <?php } ?>
        
        function complete_calendar(month,year){
            var m = month;
            var a = year;
           
            <?php
            if(isset($_SESSION['username'])){?>
                build_calendar_connect(m,a);
            <?php $username = $_SESSION['username'];
                $requete = $connexion->prepare("SELECT * FROM utilisateurs WHERE username = '$username'");
                $requete->execute();
                while($color = $requete->fetch()){
                    if($color['couleur_sam'] != null && $color['couleur_dim'] != null){?>
                    customize('<?php echo $color['couleur_sam'] ?>','<?php echo $color['couleur_dim'] ?>',a,m);
              <?php }else { ?>
                        customize('red','palevioletred',a,m);
                <?php }
                    if($color['ferie'] != null && $color['couleur_ponts'] != null){?>
                        JoursFeries (a,m,'<?php echo $color['ferie'] ?>','<?php echo $color['couleur_ponts'] ?>');
              <?php }else { ?>
                JoursFeries (a,m,'lightblue','lightgreen');
                <?php }
                }
            }else { ?>
                build_calendar(m,a);
                customize('red','palevioletred',a,m);
                JoursFeries (a,m,'lightblue', 'lightgreen');

            <?php } ?>
        }
        complete_calendar(m,a);

        </script>
        <?php
        ?>
    <footer>
        <p>Un problème ? Une question ?</p>
        <a href="contact.php">Contactez nous !</a>
    </footer>
    <script src="https://kit.fontawesome.com/d435114b5f.js" crossorigin="anonymous"></script>
</body>
</html>