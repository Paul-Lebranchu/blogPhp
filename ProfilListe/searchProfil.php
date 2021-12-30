<?php
	include '../Commun/connexion.php';
	$userName = '%'.$_POST['userName'].'%';
	$rq = "SELECT id, userName, image FROM utilisateur WHERE userName LIKE :userName   ORDER BY userName";

	$res = $bd->prepare($rq);
	$res->execute( array(
		":userName" => $userName,
	));
	$resultat = $res->fetchAll();

	echo json_encode($resultat);

 ?>
