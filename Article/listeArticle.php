<?php
include "../Commun/connexion.php";
include "../Commun/footer.php";
include "../Commun/menu.php";

//redirection vers page de connexion si pas connecté
if(!key_exists('id', $_SESSION)){
	header("Location: ..");
}
 ?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<script src="../Style/js/bootstrap.js"></script>
		<link rel="stylesheet" href="../Style/css/bootstrap.css"  />
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="../Style/jquery/jquery.min.js"></script>
		<title> Liste des articles </title>
	</head>

	<body class="bg-dark">

		<?php echo $menu;?>

		<main class="bg-light" >
			<div class = "container">
				<h1> Liste des articles </h1>

				<form id="search" method="POST" enctype="" >
					<div class='form-group col' >
						<label for="texte"> Recherche par titre</label>
						<input type="text" id="texte" name="texte" onchange='recherche()'>
						<p class='err' id='errSearch'> </p>

						<input type="text" name="fauxinput" class="fauxinput" value="">
					</div>
				</form>
				
				<table class='table table-dark table-striped table-bordered table-responsive table-hover align-middle text-center'>
					<thead>
						<th> Auteur </th>
						<th> Titre </th>
						<th width='20px'> Nombre de commentaire </th>
					</thead>
					<tbody id='article'></tbody>
				</table>

				<a href='addArticle.php'><button class='btn btn-outline-dark'> Ajouter un article </button></a>
			</div>
		</main>

		<?php echo $footer;?>

	</body>
</html>

<script>

	let ajax = new XMLHttpRequest();
	ajax.open("GET", "getAllArticle.php", true);
	ajax.send();
	ajax.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			//récupère et traduis les infos du script sous forme de tableau
			let data = JSON.parse(this.responseText);
			let html = "";
			//créé le html contenant les ligne de la table des article
			for(let i = 0; i < data.length; i++){

				html += "<tr data-id='" + data[i].id +"'>";
					html += "<td width='200px' class='text-center'> <figure>";
					html += "<img width ='100px' src='"+data[i].image +"' alt='image de profil' class='rounded-circle'>";
					html += "<figcaption> <a href='../Profil/profil.php?id=" + data[i].auteur + "'> " + data[i].userName + "</a> </figcaption>";
					html += "</figure></td>";
					html += "<td> <a href='article.php?id=" + data[i].id + "&auteur=" + data[i].userName + "&titre= " + data[i].titre +"'>" + data[i].titre + " </a> </td>";
					html += "<td>" + data[i].com + "</td>";
				html += "</tr>";
			}
			$('#article').html(html);
		}
	}

	//function de recherche d'article
	function recherche(){

		//récupère la valeur recherchée
		let search = document.getElementById("texte").value;
		//si il n'y a rien dans search, met un message d'erreur
		if(search == ""){
			$('#errSearch').text("Veuillez indiquez un titre ou un auteur svp");
		}else{
			//sinon, réinitialise message d'erreur
			$('#errSearch').text("");
			//envoie la requete
			let ajax = new XMLHttpRequest();

			ajax.open("POST", "searchByTitre.php", true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.send("search=" + search);
			ajax.onreadystatechange = function () {
				if (this.readyState == 4 && this.status == 200) {
					//vide la table
					$("#article").empty();
					//récupère et traduis les infos du script sous forme de tableau
					let data = JSON.parse(this.responseText);
					let html = "";
					//créé le html contenant les ligne de la table des article
					for(let i = 0; i < data.length; i++){

						html += "<tr data-id='" + data[i].id +"'>";
							html += "<td width='200px' class='text-center'> <figure>";
							html += "<img width ='100px' src='"+data[i].image +"' alt='image de profil' class='rounded-circle'>";
							html += "<figcaption> <a href='../Profil/profil.php?id=" + data[i].auteur + "'> " + data[i].userName + "</a> </figcaption>";
							html += "</figure></td>";
							html += "<td> <a href='article.php?id=" + data[i].id + "&auteur=" + data[i].userName + "&titre= " + data[i].titre +"'>" + data[i].titre + " </a> </td>";
							html += "<td>" + data[i].com + "</td>";
						html += "</tr>";
					}
					$('#article').html(html);

				}
			}
		}
	}
</script>

<style>
/*Cache le champ de recherche bloquant l'envoi du formulaire*/
.fauxinput {
  display:none !important;
}
</style>
