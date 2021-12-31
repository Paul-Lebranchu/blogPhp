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
		<title> <?php echo $_GET['titre']; ?> </title>
	</head>

	<body class="bg-dark">

		<?php echo $menu;?>

		<main class="bg-light" >
			<div class = "container">

				<div id='auteur' class='border border-dark '>
					<h2 class='border-bottom'> Auteur :</h2>
					<?php
					//selection de l'image de l'auteur
					$requete = "SELECT image FROM utilisateur WHERE userName = :userName";
					$res = $bd->prepare($requete);
					$res->execute(array(
						":userName" => $_GET['auteur']
					));
					$resultat =$res->fetch();
					$src = $resultat['image'];

					?>
					<img src="<?php echo $src?>" alt="image de profil" width='100px;'class="rounded-circle" >
					<?php echo $_GET['auteur']; ?>

				</div>

				<div id = 'article' class="border border-dark">
					<?php
					echo "<h2 class='border-bottom'> Titre : ".$_GET['titre']."</h2>";

					//récupère le contenu de l'article
					$requete = "SELECT contenu FROM article WHERE id = :id";
					$res = $bd->prepare($requete);
					$res->execute(array(
						":id" => $_GET['id']
					));
					$resultat = $res->fetch();
					//afiche l'article
					echo $resultat['contenu'];
					?>
				</div>

				<div id="comment" class="border border-dark" >
					<h2 class='border-bottom'> Commentaire(s) </h2>

					<p> WIP </p>
				</div>

				<div id="newComment" class="border border-dark" >
					<h2 class='border-bottom' > Poster votre commentaire</h2>

					<p> WIP </p>
				</div>
			</div>
		</main>

		<?php echo $footer;?>
	</div>
