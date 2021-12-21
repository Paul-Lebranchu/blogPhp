<?php
	include '../Commun/connexion.php';
	$requete = "SELECT id, userName, image FROM utilisateur";
	$res = $bd->query($requete);
	$resultat = $res->fetchAll();
	echo json_encode($resultat);
?>
