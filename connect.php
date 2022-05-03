<?php
try {
    $bdd = "mysql:host=localhost:3306;dbname=agenda";
    $connexion = new PDO($bdd, "root", "");

    }
    catch(PDOException $e) {
    exit('Erreur : '.$e->getMessage());
    }
?>