<?php
	include '../Commun/connexion.php';

	//requete de suppression de l'article en se basant sur l'id récupérer dans le fichier article.php
	$requete  = "DELETE FROM article where id = :id ";
	$res = $bd->prepare($requete);
	$res->execute(array(
		":id" => $_POST['idArt']
	));

	echo("suprresion réussi");
 ?>
