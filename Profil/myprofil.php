<?php
include "../Commun/connexion.php";
include "../Commun/footer.php";
include "../Commun/menu.php";
include "../Commun/deconnexion.php";
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
					//div des boutons
					echo "<div id='control' class='row'>";
						//bouton édition de profil
						echo("<div class='col-2'><button class='btn btn-warning'>Edition le profil </button></div>");
						//bouton de suppression de profil
						echo("<div class='col-2'><button class='btn btn-danger'>Supprimer le profil </button></div>");
					echo("</div>");
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
	ajax.open("GET", "infoMyProfil.php", true);
	ajax.send();

	ajax.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			//récupère et traduis les infos du script sous forme de tableau
			let data = JSON.parse(this.responseText);
			//créé le html du profil
			let html = "<div class='row align-items-center'>";

			html += "<div class = 'col-3'>"
			html += "<img class='img-thumbnail' src='" + data.image + "' alt='image du profil de " + data.userName +"'>";
			html +="</div>"

			html += "<div class = 'col-9'>"
			html += "<p id='user'> Nom d'utilistaeur : " + data.userName + "</p>";
			html += "<p id='mail'> Mail : " + data.mail + "</p>";
			html += "<p id='tel'> Téléphone : " + data.tel + "</p>";
			html += "<p id='nbArticle'> Nombre d'article écrit : WIP </p>";
			html += "<p id='nbCom'> Nombre de commentaire écrit : WIP</p>";
			html +="</div>"

			html +="</div>"
			//ajout le code html au profil
			$('#profil').html(html);
		}
	};
</script>
