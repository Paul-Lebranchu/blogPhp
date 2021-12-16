<?php

include "Commun/connexion.php";
include "Commun/footer.php";
include "Commun/menu.php";

 ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<script src="Style/js/bootstrap.js"></script>
		<link rel="stylesheet" href="Style/css/bootstrap.css"  />
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="../Style/jquery/jquery.min.js"></script>
		<title> Accueil </title>
	</head>

	<body class="bg-dark">

		<?php echo $menu;?>

		<main class="bg-light">
			<div class = "container">
				<h1> Page d'accueil / connexion </h1>

				<p> Bienvenue! veuillez remplir vous connecter ou vous inscrire si vous n'avez
				pas encore créer de compte </p>

				<div>
					<button class="btn btn-primary" id="connexion"> Connexion </button>
					<button class="btn btn-primary" id="inscription"> Inscription </button>
				</sdiv>
				<div>
					<form id='log' method="post" enctype="multipart/form-data">
					</form>
				</div>

				<div>
					<button class="btn btn-info" id="rgpd"> Politique de confidentialité des données </button>
				</div>

				<div id="confidentiel">
				</div>
			</div>
		</main>

		<?php echo $footer; ?>

	</body>
</html>

<script>
//gestion de la connexion:
//formulaire de connexion
let connexion ="<label for='user'>Nom utilisateur : </label>";
connexion += "<input type='text' id='user' name='user' required><br><br>";
connexion +="<label for='password'>Mot de passe : </label>"
connexion += "<input type='password' id='password' name='password' required><br><br>";
connexion += "<input type='submit' value='Connexion'>";
//faire apparaitre le formulaire de connexion
$("#connexion").click(function(){
	//supprime contenu du formulaire
	$("#log").empty();
	//recréer contenu formulaire
	$("#log").html(connexion);
})
//action appellant le script de connexion

//gestion de l'inscription
//formulaire d'inscription
let inscription ="<label for='userInscription'>Nom utilisateur : </label>";
inscription += "<input type='text' id='userInscription' name='userInscription' required><br><br>";
inscription +="<label for='passwordInscription'>Mot de passe : </label>"
inscription += "<input type='password' id='passwordInscription' name='passwordinscription' required><br><br>";
inscription +="<label for='mail'>Adresse mail : </label>"
inscription += "<input type='mail' id='mail' name='mail' required><br><br>";
inscription +="<label for='tel'>Téléphone : </label>"
inscription += "<input type='tel' id='tel' name='tel' required ><br><br>";
inscription +="<label for='image'>Photo de profil : </label>"
inscription += "<input type='file' name='image' id='image' accept='image/png, image/jpeg'><br><br>";
inscription += "<input type='submit' value='Inscription'>";

//faire apparaitre le forumaire d'inscription
$("#inscription").click(function(){

	//supprime contenu du formulaire
	$("#log").empty();
	//recréer contenu formulaire
	$("#log").html(inscription);
	//ajout dela fonction d'inscription au formualire
	$("#log").attr('onsubmit', 'return inscriptionUtilisateur()');
})

//action appellant le script d'inscription
function inscriptionUtilisateur(){
	//récupère valeur champ formulaire
	let userName = document.getElementById("userInscription").value;
	let password = document.getElementById("passwordInscription").value;
	let mail = document.getElementById("mail").value;
	let tel = document.getElementById("tel").value;
	let image = document.getElementById("image").value;
	/* WIP: faire les verife dans le formulaire(verif que le nom d'utilisateur n'est pas déjà)
	+ meilleur message d'erreur dans formulaire  + redirection vers page de profil si inscription réussie
	+ création d'une variable session*/
	let ajax = new XMLHttpRequest();
	ajax.open("POST", "../Inscription_Connexion/inscription.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("userName=" + userName + "&password=" + password + "&mail= " + mail
    + "&tel=" + tel + "&image=" + image);

	ajax.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			alert("inscription réussie");
		}

	}
	return false;
}

//politique de confidentialité
let confidential = "<p> Vos données seront utilisées dans le but de vous identifier et de vous montrer le contenu accesible pour vous. </p>";
confidential += "<p> Votre adresse mail et votre numéro de téléphone seront utilisées pour vous contactez en cas de problèmes. Ces données ne sont pas accesible aux autres utilisateurs </p>";
confidential += "<p> Nous nous engageons à ne pas utilisées vos données personnelles dans un but commercial </p>";
confidential += "<p> Vos données seront conservées jusqu'à la suppression de compte ou jusqu'à ce que vous formuliez une demande de suppression des données </p>";

$("#rgpd").click(function(){
	$('#confidentiel').html(confidential);
})
</script>
