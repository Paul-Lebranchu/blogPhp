<?php
	include '../Commun/connexion.php';

	//requête de modification de profil
	$requete = "UPDATE utilisateur  SET userName = :userName, mail = :mail, tel = :tel WHERE id = :id";
	$res = $bd->prepare($requete);
	$res->execute( array(
		":userName" => $_POST['userName'],
		":mail" => $_POST['mail'],
		":tel" => $_POST['tel'],
		":id" => $_SESSION['id']
	));
	echo "modification réussi";

 ?>
