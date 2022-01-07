<?php
	include "../Commun/connexion.php";
	$requete = "DELETE FROM commentaire WHERE id = :id";
	$res = $bd->prepare($requete);
	$res->execute(array(
		':id' => $_POST['id'],
	));
	echo("suprresion réussi");
 ?>
