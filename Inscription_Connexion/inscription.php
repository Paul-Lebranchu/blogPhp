<?php
	include '../Commun/connexion.php';
	//cryptage du mot de passe
	$password = $_POST["password"];
	$code = password_hash($password, PASSWORD_BCRYPT);

	//enregistrer l'image
	//on se place dans le bon repertoire et on choissit le fichier où enregistrer l'image
	chdir('../');
	$currentdir = getcwd();
	$image = $currentdir.'/Asset/PhotoProfil/'.$_POST["userName"].'.jpg';

	//on met une image par défaut lors de l'inscription
	$url = "https://apsec.iafor.org/wp-content/uploads/sites/37/2017/02/IAFOR-Blank-Avatar-Image.jpg";

	//On enregistrer notre image
	file_put_contents($image, file_get_contents($url));

	$image = '../Asset/PhotoProfil/'.$_POST["userName"].'.jpg';
	//création du compte
	$requete = "INSERT INTO utilisateur (userName, password, tel, mail, image) VALUES (:userName, :password, :tel, :mail, :image)";

	$res = $bd->prepare($requete);
	$res->execute( array(
		":userName" => $_POST["userName"],
		":password" => $code,
		":tel" => $_POST["tel"],
		":mail" => $_POST["mail"],
		":image" => $image,
	));
	$_SESSION['id'] = $bd->lastInsertId();

	echo $bd->lastInsertId();
	var_dump($_FILES);
?>
