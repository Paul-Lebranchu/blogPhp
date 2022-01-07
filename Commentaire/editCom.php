<?php
	include '../Commun/connexion.php';

	$requete = "UPDATE commentaire SET contenu = :com  WHERE id = :id";
	$res = $bd->prepare($requete);
	$res->execute(array(
		":com" => $_POST["com"],
		":id" => $_POST["id"]
	));
	echo "modification réussi";
 ?>
