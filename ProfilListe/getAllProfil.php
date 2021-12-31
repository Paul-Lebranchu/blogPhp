<?php
	include '../Commun/connexion.php';
	//récupère les infos sur tout les profils
	$requete = "SELECT id, userName, image FROM utilisateur ORDER BY userName";
	$res = $bd->query($requete);
	$resultat = $res->fetchAll();

	//parcours le tableau des profils et ajoute le nb d'article et de commentaire écrit
	for($i = 0; $i < count($resultat); $i++){
		//selectionne le nombre d'article écrit par l'utilisateur
		$requete2 = "SELECT count(*) FROM article WHERE auteur = :id";
		$res2 = $bd->prepare($requete2);
		$res2->execute( array(
			":id" => $resultat[$i]['id']
		));
		$nbArticle = $res2->fetch();
		$resultat[$i]['nbArticle'] = $nbArticle[0] ;

		//selectionne le nombre de commentaire écrit par l'utilisateur
		$requete3 = "SELECT count(*) FROM commentaire WHERE auteur = :id";
		$res3 = $bd->prepare($requete3);
		$res3->execute( array(
			":id" => $resultat[$i]['id']
		));
		$nbCom = $res3->fetch();
		$resultat[$i]['nbCom'] = $nbCom[0] ;
	}
	echo json_encode($resultat);
?>
