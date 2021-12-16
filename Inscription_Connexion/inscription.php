<?php
	include '../Commun/connexion.php';
	//cryptage du mot de passe
	$password = $POST_["password"];
	$code = password_hash($password, PASSWORD_BCRYPT);

	//création du compte
	$requete = "INSERT INTO utilisateur (userName, password, tel, mail, image)
	VALUES (:userName, :password, :tel, :mail, :image)";

	$res = $bd->prepare($requete);
	echo($code);
	echo($_POST["userName"]);
	echo($_POST["tel"]);
	echo($_POST["mail"]);
	echo($_POST["photo"]);
	$res->execute( array(
		":userName" => $_POST["userName"],
		":password" => $code,
		":tel" => $_POST["tel"],
		":mail" => $_POST["mail"],
		":image" => $_POST["image"],
	));

	echo $bd->lastInsertId();

?>
