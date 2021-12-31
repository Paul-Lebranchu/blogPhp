<?php
include "../Commun/connexion.php";
include "../Commun/footer.php";
include "../Commun/menu.php";

 ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<script src="../Style/js/bootstrap.js"></script>
		<link rel="stylesheet" href="../Style/css/bootstrap.css"  />
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="../Style/jquery/jquery.min.js"></script>
		<title> Liste des profils </title>
	</head>

	<body class="bg-dark">

		<?php echo $menu;?>

		<main class="bg-light" >
			<div class = "container">
				<h1> Liste des profils </h1>

				<form id="search" method="POST" enctype="">
					<div class='form-group col'>
						<label for='searchUser'> Recherche D'utilisateurs </label>
						<input type='text' id='searchUser' name='searchUser' onchange='recherche()'/>

						<input type="text" name="fauxinput" class="fauxinput" value="">
					</div>
				</form>
				<?php
				//si utilistauer connecté
				if(key_exists('id', $_SESSION)){
					//formulaire de recherche d'utilisateur
					//créer la table qui contiendra les infos le nom des profils, leur image et un lien vers leur page
					echo("<table class='table table-dark table-striped table-bordered table-responsive table-hover'>
							<thead>
								<th> Photo de profil</th>
								<th> Nom utilisateur </th>
								<th> Nombre d'article(s) écrit(s) </th>
								<th> Nombre de commentaire </th>
							</thead>
							<tbody id='profil'></tbody>
						</table>");

				}
				//utilistaeur hors ligne-> remis en page de connexion
				else{
					header('location: ../');
				}
				 ?>
			</div>
		</main>
		<?php echo $footer;?>
	</body>
</html>

<script>
	//création de la liste des annonces
	let ajax = new XMLHttpRequest();
	ajax.open("GET", "getAllProfil.php", true);
	ajax.send();
	ajax.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			//récupère et traduis les infos du script sous forme de tableau
			let data = JSON.parse(this.responseText);
			let html = "";
			//créé le html contenant les ligne de la table des profils
			for(let i = 0; i < data.length; i++){
				html += "<tr data-id='" + data[i].id +"'>";
					html += "<td> <img class='rounded-circle' width='100px' src='" + data[i].image + "' alt = 'image de profil de :" + data[i].userName +"'> </td>";
					html += "<td> <a href='../Profil/profil.php?id=" + data[i].id + "'>" + data[i].userName + " </a></td>";
					html += "<td> " + data[i].nbArticle + " </td>";
					html += "<td> " + data[i].nbCom + " </td>";
				html += "</tr>";
			}
			//ajout le code html à la table des profils
			$('#profil').html(html);
		}
	};

	//Fonction recherche
	function recherche(){

		let userName = document.getElementById('searchUser').value;
		let ajax = new XMLHttpRequest();

		ajax.open("POST", "searchProfil.php", true);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("userName=" + userName);
		ajax.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				//nettoie la table d'utilisateur
				$('#profil').empty();
				let data = JSON.parse(this.responseText);
				let html = "";
				//créé le html contenant les ligne de la table des profils
				for(let i = 0; i < data.length; i++){
					html += "<tr data-id='" + data[i].id +"'>";
						html += "<td> <img width='100px' src='" + data[i].image + "' alt = 'image de profil de :" + data[i].userName +"'> </td>";
						html += "<td> <a href='../Profil/profil.php?id=" + data[i].id + "'>" + data[i].userName + " </a></td>";
						html += "<td> WIP </td>";
						html += "<td> WIP </td>";
					html += "</tr>";
				}
				//ajout le code html à la table des profils
				$('#profil').html(html);
			}
		}
	}
</script>

<style>
.fauxinput {
  display:none !important;
}
</style>
