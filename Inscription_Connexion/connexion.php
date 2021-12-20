<?php
	include '../Commun/connexion.php';
	//Selection du mot de passe haché
	$requete = "SELECT id, password FROM utilisateur WHERE userName = :userName";
	$res = $bd->prepare($requete);
	$res->execute( array(
		":userName" => $_POST['userName'],
	));
	$resultat = $res->fetchAll();
	$hash = $resultat[0]['password'];

	//vérifie la validité du mot de passe
	if (password_verify($_POST['password'], $hash)) {
    	$ok = 'ok';
		echo json_encode($ok);
		//création de la variable de session contenant l'id de l'utilisateur
		$_SESSION['id'] = $resultat[0]['id'];

	} else {
		//gestion de l'erreur de mot de passe invalide
    	$err = 'ko';
		echo json_encode($err);
	}
?>
