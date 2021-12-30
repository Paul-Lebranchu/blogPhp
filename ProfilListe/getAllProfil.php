<?php
	include '../Commun/connexion.php';
	$requete = "SELECT id, userName, image FROM utilisateur ORDER BY userName";
	$res = $bd->query($requete);
	$resultat = $res->fetchAll();
	echo json_encode($resultat);
?>
