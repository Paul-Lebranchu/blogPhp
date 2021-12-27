<?php
	include '../Commun/connexion.php';
	//verifie si l'adresse mail est déjà utilisée lors de l'édition de profil
	$requete = "SELECT count(mail) FROM utilisateur where mail = :mail AND mail != :actualMail";
	$res = $bd->prepare($requete);
	$res->execute( array(
		":mail" => $_POST['mail'],
		":actualMail" => $_POST['actualMail']
	));

	$resultat = $res->fetchAll();
	echo json_encode($resultat);
?>
