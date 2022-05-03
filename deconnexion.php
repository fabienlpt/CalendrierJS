<html>

<head>
    <title>Déconnection</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
<?php 
session_start(); 
$_SESSION = array();
session_destroy() ;
header("refresh:0;url=index.php");

?>
</body>
</html>