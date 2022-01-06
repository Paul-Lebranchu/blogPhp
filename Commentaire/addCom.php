<?php
	include '../Commun/connexion.php';

	$requete = "INSERT INTO commentaire(contenu, auteur, article) VALUES (:com, :auteur, :article)";
	$res = $bd->prepare($requete);
	$res->execute(array(
		":com" => $_POST["com"],
		":auteur" => $_SESSION["id"],
		":article" => $_POST["article"]
	));


 ?>
