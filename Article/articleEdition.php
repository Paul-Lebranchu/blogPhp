<?php
	include '../Commun/connexion.php';

	$requete = "UPDATE article SET titre = :titre, contenu = :contenu  WHERE id = :id";
	$res = $bd->prepare($requete);
	$res->execute(array(
		":titre" => $_POST["titre"],
		":contenu" => $_POST["contenu"],
		":id" => $_POST["id"]

	));
	echo "modification réussi";
 ?>
