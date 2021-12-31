<?php
include "../Commun/connexion.php";
include "../Commun/footer.php";
include "../Commun/menu.php";


//récupère les valeurs du profil pour la modal d'édition du profil
$requete = "SELECT userName, tel, mail, image FROM utilisateur WHERE id= :id";
$res = $bd->prepare($requete);
$res->execute( array(
	":id" => $_SESSION['id']
));
$resultat = $res->fetch();

//rajoute élément pour transformer en chaine de caractère dans javascript
$userName = "'".$resultat["userName"]."'";
$mail = "'".$resultat["mail"]."'";



 ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<script src="../Style/js/bootstrap.js"></script>
		<link rel="stylesheet" href="../Style/css/bootstrap.css"  />
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="../Style/jquery/jquery.min.js"></script>
		<title> Accueil </title>
	</head>

	<body class="bg-dark">

		<?php echo $menu;?>

		<main class="bg-light" >
			<div class = "container">
				<h1> Mon Profil </h1>
				<?php
				//si utilistauer connecté
				if(key_exists('id', $_SESSION)){
					//créer la div qui continedra les infos sur le profil, contenu généré par script
					echo ("<div id='profil'></div>");
				}
				//utilistaeur hors ligne-> remis en page de connexion
				else{
					header('location: ../');
				}
				 ?>
			</div>

			<!-- Modal pour la suppresion profil -->
			<div class="modal fade" id="delModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content bg-dark text-light">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Suppression de compte</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<p> Voulez-vous vraiment supprimer  définitivement votre compte?</p>
							<p> Vos article et vos commentaire resteront affichés mais vous ne serez plus identifiés dessus </p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" id="confirmDel" data-bs-dismiss="modal">Supprimer mon compte</button>
							<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal pour l'édition de profil -->
			<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content bg-dark text-light">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Modification de compte</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form>
							<div class='row'>

								<div class='form-group col'>
									<label for='userEdit'>* Mail : </label>
									<input type='text' class='form-control' id='userEdit' name='userEdit' value='<?php echo $resultat['userName']?>' onchange='verifUserName()'>
									<p class='err' id='errUserName'> </p>
								</div>

							<br></div>
							<div class='row'>

								<div class='form-group col'>
									<label for='mailEdit'>* Mail : </label>
									<input type='email' class='form-control' id='mailEdit' name='mailEdit' value='<?php echo $resultat['mail']?>' placeholder='ex : xyz@exemple.com' onchange='verifMail()'>
									<p class='err' id='errMail'> </p>
								</div>

								<div class='form-group col'>
									<label for='telEdit'>* Téléphone : </label>
									<input type='tel' class='form-control' id='telEdit' name='telEdit' value='<?php echo $resultat['tel']?>' pattern='[0-9]{10}' placeholder ='ex: 0123456789'>
									<p class='err' id='errTel'> </p>
								</div>

							<br></div>
							<div class='row'>

								<div class='modal-footer'>
									<input class='btn btn-warning' id ='confirmEdit' type='submit' value='Modifier le compte'>
									<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
								</div>
							</div>
						</form>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal de modifcation de mot de passe -->
			<div class="modal fade" id="editPassModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content bg-dark text-light">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Modification de mot de passe</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form>
							<div class='row'>

								<div class='form-group col'>
									<label for='newPass'>* Nouveau mode passe : </label>
									<input type='password' class='form-control' id='newPass' name='newPass'>
									<p class='err' id='errPass'> </p>
								</div>

							<br></div>

							<div class='row'>

								<div class='form-group col'>
									<label for='confirm'>* Confirmation nouveau mot de passe : </label>
									<input type='password' class='form-control' id='confirm' name='confirm'>
									<p class='err' id='errConfirm'> </p>
									<p class='err' id='errDiff'> </p>
								</div>

							<br></div>
							<div class='row'>

								<div class='modal-footer'>
									<input class='btn btn-warning' id ='changePass' type='submit' value='Modifier le mot de passe'>
									<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
								</div>
							</div>
						</form>
						</div>
					</div>
				</div>
			</div>
		</main>
		<?php echo $footer;?>
	</body>
</html>

<script>

	//création de la liste des annonces
	let ajax = new XMLHttpRequest();
	ajax.open("GET", "infoMyProfil.php", true);
	ajax.send();

	ajax.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			//récupère et traduis les infos du script sous forme de tableau
			let data = JSON.parse(this.responseText);
			//créé le html du profil
			let html = "<div class='row align-items-center'>";

			html += "<div class = 'col-3' >"
				html += "<img class='img-thumbnail rounded-circle' src='" + data.image + "' alt='image du profil de " + data.userName +"'>";
				html += "<button class='btn btn-info'>Editer la photo de profil </button>";
			html +="</div>"

			html += "<div class = 'col-9'>"
				html += "<p id='user'> Nom d'utilistaeur : " + data.userName + "</p>";
				html += "<p id='mail'> Mail : " + data.mail + "</p>";
				html += "<p id='tel'> Téléphone : " + data.tel + "</p>";
				html += "<p id='nbArticle'> Nombre d'article écrit : " + data.nbArticle + " </p>";
				html += "<p id='nbCom'> Nombre de commentaire écrit : " + data.nbCom + "</p>";

				//bouton édition de profil
				html += "<button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editModal'>Editer le profil </button>";
				//bouton de suppression de profil
				html += "<button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#delModal'>Supprimer le profil </button>";
				//bouton modification mot de passe
				html += "<button class='btn btn-success' data-bs-toggle='modal' data-bs-target='#editPassModal'>Modifier le mot de passe </button>";
				html +="</div>"

			html +="</div>"
			//ajout le code html au profil
			$('#profil').html(html);
		}
	};
	//Supression de profil
	function suppression(){
		let ajax = new XMLHttpRequest();
		ajax.open("GET", "deleteProfil.php", true);
		ajax.send();

		ajax.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				alert("suppression réussi");
				//redirection vers page d'accueil
				document.location.href="../";
			}
		}
	}
	//bouton suppression faisant apparaitre modal de suppresion de profil
	let delCompte = document.getElementById('delModal');
	delCompte.addEventListener('show.bs.modal', function (event) {
		//lien bouton suppression de la modal de suppression - fonction suppression
		$('#confirmDel').click(function(){
			suppression();
		});

	})


	//edition de profil
	//bouton édition profil faisant apparaitre modal de suppresion de profil
	let editCompte = document.getElementById('editModal');
	editCompte.addEventListener('show.bs.modal', function (event) {
		//lien bouton suppression de la modal de suppression - fonction suppression
		$('#confirmEdit').click(function(){
			//récupère le resultat de la function edit
			let res = edit();
			/* si res vaut 0, il y a des erreur dans le formulaire et on ne souhaite pas fermer
			la modal -> return false */
			if(res == 0){
				return false;
			}
		});

	})
	//fonction lié au forlulaire d'édition (vérification mail et vérification pseudo dispo)
	function edit(){
		//récupère élément du formulaire
		let userName = document.getElementById('userEdit').value;
		let mail = document.getElementById('mailEdit').value;
		let tel = document.getElementById('telEdit').value;

		//récupère les erreurs qui peuvent être généré par verifMail et verifUserName
		let errUse = $('#errUserName').text();
		let errMailverif = $('#errMail').text();

		//initialise la valeur à retourner
		let formOk = 1;

		//verifie qu'il n'y ait pas d'erreur dans le formualaire
		//userName
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

		//mail
		let regMail = /[a-z]*@[a-z]*\.[a-z]{2,3}/
		if(errMailverif == "Votre adresse mail est déjà utilisée par un autre membre"){
			formOk = 0;
		}else{
			if(mail == "" || !(regMail.test(mail))){
				$('#errMail').text("veuillez renseignez une adresse mail valide svp");
				formOk = 0;
			}
			else{
				$('#errMail').text("");
			}
		}

		//tel
		let regTel = /[0-9]{10}/;
		if(tel == "" || !(regTel.test(tel))){
			$('#errTel').text("veuillez renseignez un numéro de téléphone valide svp (format 10 chiffres)");
			formOk = 0;
		}else{
			$('#errTel').text("");
		}
		//si formOk vaut 1, execute le script d'édition de profil
		if (formOk == 1){

			let ajax = new XMLHttpRequest();
			ajax.open("POST", "editProfil.php", true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.send("userName=" + userName + "&mail=" + mail
		    + "&tel=" + tel);
			ajax.onreadystatechange = function () {
				if (this.readyState == 4 && this.status == 200) {
					alert("Modifiaction de profil réussie");
					document.location.href="/Profil/myprofil.php";
				}
			}
			return false;
		}
		//retourne formOk pour tester si l'on doit fermé ou non la modal d'édition
		return formOk;
	}

	//verifie si le nom d'utilisateur n'est pas utilisé (version édition)
	function verifUserName(){
		//récupère le nom actuel du compte et le nom présent dans le formulaire
		let actualName = <?php echo $userName; ?>;
		let userName = document.getElementById("userEdit").value;

		let ajax = new XMLHttpRequest();
		ajax.open("POST", "../Profil/verifUserNameDisponibleEdit.php", true);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("userName=" + userName + "&actualName=" + actualName);
		ajax.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				//parse les données renvoyés par la requête et vérifie que le pseudo n'est pas dans la base (sauf si il s'agit de l'ancien pseudo du compte)
				let data = JSON.parse(this.responseText);
				if(data[0]['count(userName)'] != 0){
					$('#errUserName').text("Votre pseudo est déjà utilisé par un autre membre");
				}else{
					$('#errUserName').text("");
				}
			}

		}
		return false;
	}

	//vérifie si l'adresse mail n'est pas déjà utilisée (version édition)
	function verifMail(){
		//récupère le mail actuel du compte et le mail présent dans le formulaire
		let actualMail = <?php echo $mail; ?>;
		let mail = document.getElementById("mailEdit").value;

		let ajax = new XMLHttpRequest();
		ajax.open("POST", "../Profil/verifMailDispoEdit.php", true);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("mail=" + mail + "&actualMail=" + actualMail);
		ajax.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				//parse les données renvoyés par la requête et vérifie que le pseudo n'est pas dans la base (sauf si il s'agit de l'ancien pseudo du compte)
				let data = JSON.parse(this.responseText);
				if(data[0]['count(mail)'] != 0){
					$('#errMail').text("Votre adresse mail est déjà utilisée par un autre membre");
				}else{
					$('#errMail').text("");
				}
			}

		}
		return false;
	}

	//changer le mot de passe
	function editPass(){
		//reset des erreurs
		$('#errPass').text("");
		$('#errConfirm').text("");
		$('#errDiff').text("");
		//récupère la valeur du nouveau mot de passe et vérifie qu'elle est identique au mot de passe de confirmation
		let newPass = document.getElementById("newPass").value;
		let confirm = document.getElementById("confirm").value;

		//variable contenant le res de la comparaison
		let compare = 1;

		//verif des erreurs
		if(newPass == ""){
			$('#errPass').text("Vous devez indiquez un nouveau mot de passe");
			compare = 0;
		}
		if(confirm == ""){
			$('#errConfirm').text("Vous devez confirmez votre nouveau mot de passe");
			compare = 0;
		}
		if(newPass != confirm){
			$('#errDiff').text("Votre mot de passe et votre confirmation sont différents");
			compare = 0;
		}

		//si les deux mots de passe sont non vides et qu'ils sont identiques, change le mot de passe + déconnecte
		if(compare == 1){
			//requete de modification du mot de passe
			let ajax = new XMLHttpRequest();
			ajax.open("POST", "editMotDePasse.php", true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.send("password=" + newPass);
			ajax.onreadystatechange = function () {
				if (this.readyState == 4 && this.status == 200) {
					alert("Modifiaction du mot de passe réussie");
					//appel script deconnexion
					deconnexion();
				}
			}
			return false;
		}
		return compare;
	}

	//bouton edition mot de passe faisant apparaitre  modal d'édition de mot de passe
	let editPassword = document.getElementById('editPassModal');
	editPassword.addEventListener('show.bs.modal', function (event) {
		//lien bouton suppression de la modal de suppression - fonction suppression
		$('#changePass').click(function(){
			//changement du mot de passe et déconnexion
			let res = editPass();
			//si le mot de passe et la confirmation ne sont pas identique, ou un champ est nulle, on ne modifie pas le mot de passe
			if(res == 0){
				return false;
			}
		});

	})

	//changer la photo de profil
</script>
