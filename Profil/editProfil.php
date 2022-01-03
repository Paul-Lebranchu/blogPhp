<?php
	include '../Commun/connexion.php';

	//selectionne le nom du fichier
	$requete = "SELECT image FROM utilisateur WHERE id = :id";
	$res = $bd->prepare($requete);
	$res->execute(array(
		":id" => $_SESSION['id']
	));
	$resultat = $res->fetch();
	$oldName = $resultat['image'];
	//definit un nouveau nom de fichier
	$newName = '../Asset/PhotoProfil/'.$_POST["userName"].'.jpg';;
	//changee le nom de l'image dans le fichier pour qu'il s'adapte au nouveau fichier
	rename($oldName,$newName);
	//requête de modification de profil
	$requete = "UPDATE utilisateur  SET userName = :userName, mail = :mail, tel = :tel, image = :image WHERE id = :id";
	$res = $bd->prepare($requete);
	$res->execute( array(
		":userName" => $_POST['userName'],
		":mail" => $_POST['mail'],
		":tel" => $_POST['tel'],
		":id" => $_SESSION['id'],
		":image" => $newName
	));

	echo "modification réussi";

 ?>
