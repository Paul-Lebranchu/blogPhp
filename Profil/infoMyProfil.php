<?php
	include '../Commun/connexion.php';
	$requete = "SELECT userName, tel, mail, image FROM utilisateur WHERE id= :id";
	$res = $bd->prepare($requete);
	$res->execute( array(
		":id" => $_SESSION['id']
	));
	$resultat = $res->fetch();
	echo json_encode($resultat);
?>
