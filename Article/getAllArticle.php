<?php
	include '../Commun/connexion.php';

	$requete = "SELECT id, auteur, titre FROM article ORDER BY id";
	$res = $bd->query($requete);
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
