<?php
	include '../Commun/connexion.php';
	//verifie si l'adresse mail est déjà utilisée lors de l'inscription
	$requete = "SELECT count(mail) FROM utilisateur where mail = :mail";
	$res = $bd->prepare($requete);
	$res->execute( array(
		":mail" => $_POST['mail']
	));

	$resultat = $res->fetchAll();
	echo json_encode($resultat);


?>
