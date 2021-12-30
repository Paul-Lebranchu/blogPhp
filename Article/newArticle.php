<?php
	include '../Commun/connexion.php';
	$requete = "INSERT INTO article (titre, contenu, auteur) VALUES (:titre, :contenu, :auteur)";

	$res = $bd->prepare($requete);
	$res->execute(array(
		":titre" => $_POST["titre"],
		":contenu" => $_POST["contenu"],
		":auteur" => $_POST["id"]
	));

 ?>
