<?php

	include '../Commun/connexion.php';
	//verifie si le nom d'utilisateur est disponible lorsque l'on fait notre édition de profil
	$requete = "SELECT count(userName) FROM utilisateur where userName = :userName AND userName != :actualName";
	$res = $bd->prepare($requete);
	$res->execute( array(
		":userName" => $_POST['userName'],
		":actualName" => $_POST['actualName']
	));

	$resultat = $res->fetchAll();
	echo json_encode($resultat);

?>
