<?php
	include '../Commun/connexion.php';
	//Selectionne tout les commentaires lié à un article
	$requete = "SELECT id, contenu, auteur FROM commentaire WHERE article = :article";
	$res =$bd->prepare($requete);
	$res->execute(array(
		':article' => $_POST["article"]
	));
	$resultat = $res->fetchAll();

	//selectionne les noms d'utilisateurs et les images de profils des utilistauers et les ajoute au tableaux des commentaires
	for($i = 0; $i < count($resultat); $i++){
		//selectionne image + username
		$requete2 = "SELECT userName, image FROM utilisateur WHERE id = :id";
		$res2 = $bd->prepare($requete2);
		$res2->execute(array(
			':id' => $resultat[$i]['auteur']

		));
		$resultat2 = $res2->fetch();

		//ajoute au tableau
		$resultat[$i]['userName'] = $resultat2[0];
		$resultat[$i]['image'] = $resultat2[1];
	}
	echo json_encode($resultat);
 ?>
