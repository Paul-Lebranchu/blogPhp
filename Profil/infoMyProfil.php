<?php
	include '../Commun/connexion.php';

	//récupère les infos sur le profil
	$requete = "SELECT userName, tel, mail, image FROM utilisateur WHERE id= :id";
	$res = $bd->prepare($requete);
	$res->execute( array(
		":id" => $_SESSION['id']
	));
	$resultat = $res->fetch();

	//compte le nombre d'article écrit par l'utilisateur
	$requete2 = "SELECT count(*) FROM article WHERE auteur = :id";
	$res2 = $bd->prepare($requete2);
	$res2->execute( array(
		":id" => $_SESSION['id']
	));
	$nbArticle = $res2->fetch();
	$resultat["nbArticle"] = $nbArticle[0];

	//compte le nombre de commentaie écrit par l'utilisteur
	$requete3 = "SELECT count(*) FROM commentaire WHERE auteur = :id";
	$res3 = $bd->prepare($requete3);
	$res3->execute( array(
		":id" => $_SESSION['id']
	));
	$nbCom = $res3->fetch();
	$resultat["nbCom"] = $nbCom[0];

	echo json_encode($resultat);
?>
