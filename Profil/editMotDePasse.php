<?php
	include '../Commun/connexion.php';
	//cryptage du nouveau mot de passe
	$password = $_POST["password"];
	$code = password_hash($password, PASSWORD_BCRYPT);

	//requête de modification de profil
	$requete = "UPDATE utilisateur  SET password = :password  WHERE id = :id";
	$res = $bd->prepare($requete);
	$res->execute( array(
		":password" => $code,
		":id" => $_SESSION['id']
	));

 ?>
