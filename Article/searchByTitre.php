<?php
	include "../Commun/connexion.php";
	//création du titre pour le filtre
	$titre = "%".$_POST['search']."%";
	//requete
	$requete = "SELECT id, auteur, titre FROM article WHERE titre LIKE :titre ORDER BY id";
	$res = $bd->prepare($requete);
	$res->execute(array(
		':titre' => $titre
	));
	$resultat = $res->fetchAll();

	//ajout le nom des auteurs aux dictionnaire json
	for($i = 0; $i < count($resultat) ; $i++){
		$requete2 = "SELECT image, userName FROM utilisateur WHERE id = :id";
		$res2 = $bd->prepare($requete2);
		$res2->execute(array(
			":id" => $resultat[$i]['auteur']
		));
		$resultat2 = $res2->fetch();
		$resultat[$i]['userName'] = $resultat2['userName'];
		$resultat[$i]['image'] = $resultat2['image'];

		//compte le nombre de commentaire
		$requete2 = "SELECT count(*)AS com FROM commentaire WHERE article = :article";
		$res2 = $bd->prepare($requete2);
		$res2->execute(array(
			":article" => $resultat[$i]['id']
		));
		$resultat2 = $res2->fetch();
		$resultat[$i]['com'] = $resultat2['com'];
	}
	echo json_encode($resultat);
 ?>
