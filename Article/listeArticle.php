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

				<table class='table table-dark table-striped table-bordered table-responsive table-hover'>
					<thead>
						<th> Auteur </th>
						<th> Titre </th>
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
					html += "<td> <a href='../Profil/profil.php?id=" + data[i].auteur + "'> " + data[i].userName + " </a></td>";
					html += "<td> " + data[i].titre + " </td>";
				html += "</tr>";
			}
			$('#article').html(html);
		}
	}
</script>
