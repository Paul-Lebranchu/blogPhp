<?php
	include "../Commun/connexion.php";
	$id = $_SESSION["id"];

	//suppresion de l'image associé au compte
	$requete = "SELECT userName FROM utilisateur WHERE id = :id";
	$res = $bd->prepare($requete);
	$res->execute( array(
		":id" => $id,
	));
	$resultat = $res->fetch();

	$file_name= "../Asset/PhotoProfil/".$resultat['userName'].".jpg";
	echo $file_name;
	unlink($file_name);
	//suppresion des commentaires
	$requete = "DELETE FROM commentaire WHERE auteur = :id";
	$res = $bd->prepare($requete);
		$res->execute( array(
			":id" => $id,
	));
	//suppressions des articles
	$requete = "DELETE FROM article WHERE auteur = :id";
	$res = $bd->prepare($requete);
		$res->execute( array(
			":id" => $id,
	));
	//suppresion du compte
	$requete = "DELETE FROM utilisateur WHERE id = :id";
	$res = $bd->prepare($requete);
		$res->execute( array(
			":id" => $id,
	));

	//déconnexion
	unset($_SESSION['id']);
	setcookie ("PHPSESSID", $_COOKIE['PHPSESSID'], time() - 864000, '/');
	session_destroy();

 ?>
