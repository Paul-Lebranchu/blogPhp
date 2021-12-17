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

let inscription = "<div class='row'>";

inscription +="<div class='form-group col'>";
inscription+= "<label for='userInscription'>* Nom utilisateur : </label>";
inscription += "<input type='text'class='form-control' id='userInscription' name='userInscription' onchange='verifUserName()'>";
inscription += "<p class='err' id='errUserName'> </p> ";
inscription += "</div>";

inscription +="<div class='form-group col'>";
inscription +="<label for='passwordInscription'>* Mot de passe : </label>";
inscription += "<input type='password' class='form-control' id='passwordInscription' name='passwordInscription'>";
inscription += "<p class='err' id='errPassword'> </p>";
inscription += "</div>";

inscription += "<br></div>";
inscription += "<div class='row'>";

inscription +="<div class='form-group col'>";
inscription += "<label for='mail'>* Adresse mail : </label>";
inscription += "<input type='email' class='form-control' id='mail' name='mail' placeholder='ex : xyz@exemple.com' onchange='verifMail()'>";
inscription += "<p class='err' id='errMail'> </p>";
inscription +="</div>";

inscription +="<div class='form-group col'>";
inscription += "<label for='tel'>* Téléphone (format: 0123456789): </label>";
inscription += "<input type='tel' class='form-control' id='tel' name='tel' pattern='[0-9]{10}' placeholder ='ex: 0123456789'>";
inscription += "<p class='err' id='errTel'> </p>";
inscription += "</div>";

inscription += "<br></div>";
inscription += "<div class='row'>";

inscription +="<div class='form-group col'>";
inscription +="<label for='image'>Photo de profil : </label>";
inscription += "<input class='form-control-file form-control ' type='file' name='image' id='image' accept='image/png, image/jpeg'>";
inscription += "<br></div>";

inscription += "</div>";
inscription += "<div class='row'>";

inscription +="<div class='form-group'>";
inscription += "<input class='btn btn-primary' type='submit' value='Inscription'> ";
inscription += "</div>";
inscription += "<br></div>";
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
	//récupère la valeur du champ d'erreur du nom  d'utilisateur et de l'adresse mail
	let errUse = $('#errUserName').text();
	let errMailverif = $('#errMail').text();
	//vérifie que les champs du formulaire soit bien rempli
	var formOk = 1;
	//erreur nom utilisateur: champ vide ou pseudo déjà pris
	if(errUse == "Votre pseudo est déjà utilisé par un autre membre"){
		formOk = 0;
	}else{
		if(userName == ""){
			$('#errUserName').text("veuillez renseignez un nom d'utilisateur svp");
			formOk = 0;
		}else{
			$('#errUserName').text("");
		}
	}
	//erreur mot de passe
	if(password == ""){
		$('#errPassword').text("veuillez renseignez un mot de passe svp");
		formOk = 0;
	}else{
		$('#errPassword').text("");
	}
	//erreur adresse mail: mail non renseignez ou mail déjà utilisée
	if(errMailverif == "Votre adresse mail est déjà utilisée"){
		formOk = 0;
	}else{
		if(mail == ""){
			$('#errMail').text("veuillez renseignez une adresse mail svp");
			formOk = 0;
		}
		else{
			$('#errMail').text("");
		}
	}

	//erreur numéro de téléphone
	if(tel == ""){
		$('#errTel').text("veuillez renseignez un numéro de téléphone svp");
		formOk = 0;
	}else{
		$('#errTel').text("");
	}
	/* WIP: redirection vers page de profil si inscription réussie
	+ création d'une variable session + enregistrer la photo en local*/
	if(formOk == 1){
		let ajax = new XMLHttpRequest();
		ajax.open("POST", "../Inscription_Connexion/inscription.php", true);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("userName=" + userName + "&password=" + password + "&mail=" + mail
	    + "&tel=" + tel + "&image=" + image);

		ajax.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				alert("inscription réussie");
			}

		}

	}
	return false;
}

function verifUserName(){
	let userName = document.getElementById("userInscription").value;
	let ajax = new XMLHttpRequest();
	ajax.open("POST", "../Inscription_Connexion/verifUserNameDisponible.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("userName=" + userName);
	ajax.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			//parse les données renvoyés par la requête et vérifie que le pseudo n'est pas dans la base
			let data = JSON.parse(this.responseText);
			if(data[0]['count(userName)'] != 0){
				$('#errUserName').text("Votre pseudo est déjà utilisé par un autre membre");
			}else{
				$('#errUserName').text("");
			}
		}
	}
}

function verifMail(){
	let mail = document.getElementById("mail").value;
	let ajax = new XMLHttpRequest();
	ajax.open("POST", "../Inscription_Connexion/verifMailDispo.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("mail=" + mail);
	ajax.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			//parse les données renvoyés par la requête et vérifie que le pseudo n'est pas dans la base
			let data = JSON.parse(this.responseText);
			console.log(data);
			console.log(data[0]['count(mail)']);
			if(data[0]['count(mail)'] != 0){
				$('#errMail').text("Votre adresse mail est déjà utilisée");
			}else{
				$('#errMail').text("");
			}
		}
	}
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
