<?php

	include '../Commun/connexion.php';
	//verifie si le nom d'utilisateur est disponible lorsque l'on fait son inscription
	$requete = "SELECT count(userName) FROM utilisateur where userName = :userName";
	$res = $bd->prepare($requete);
	$res->execute( array(
		":userName" => $_POST['userName']
	));

	$resultat = $res->fetchAll();
	echo json_encode($resultat);


?>
