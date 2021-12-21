<?php
include "../Commun/connexion.php";
include "../Commun/footer.php";
include "../Commun/menu.php";
include "../Commun/deconnexion.php";

//récuoère identifiant du profil à afficher
$id = $_GET['id'];
//récupère les infos sur le profil
$requete = "SELECT userName, tel, mail, image FROM utilisateur WHERE id= :id";
$res = $bd->prepare($requete);
$res->execute( array(
	":id" => $id,
));
$resultat = $res->fetch();

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
				<h1> Profil de <?php echo $resultat['userName']?> </h1>
				<?php
				//si utilistauer connecté
				if(key_exists('id', $_SESSION)){
					//créer la div qui continedra les infos sur le profil, contenu généré par script
					echo ("<div id='profil'>
								<div class='row align-items-center'>

									<div class = 'col-3'>
										<img class='img-thumbnail' src='" . $resultat['image'] . "' alt='image du profil de " .$resultat['userName'] . "'>
									</div>

									<div class = 'col-9'>
										<p id='user'> Nom d'utilistaeur : " . $resultat['userName'] . "</p>
										<p id='mail'> Mail : " . $resultat['mail'] . "</p>
										<p id='tel'> Téléphone : " . $resultat['tel'] . "</p>
										<p id='nbArticle'> Nombre d'article écrit : WIP </p>
										<p id='nbCom'> Nombre de commentaire écrit : WIP</p>
									</div>

								</div>
							</div>");
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
