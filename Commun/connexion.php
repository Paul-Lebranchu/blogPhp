<?php

include "varGlobale.php";

//Connexion à la base de données mysql
$dsn ='mysql:host='.MYSQL_HOST.';port='.MYSQL_PORT.';dbname='.MYSQL_DB.';charset=utf8';
$user= MYSQL_USER ;
$pass= MYSQL_PASSWORD;
try{
  $bd = new PDO($dsn,$user,$pass);
}catch (PDOException $e) {
  echo 'Connexion échouée : ' . $e->getMessage();
  exit();
}

 ?>
