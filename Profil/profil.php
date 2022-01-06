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

//compte le nombre d'article écrit par l'utilisateur
$requete2 = "SELECT count(*) FROM article WHERE auteur = :id";
$res2 = $bd->prepare($requete2);
$res2->execute( array(
	":id" => $id
));
$nbArticle = $res2->fetch();
$resultat["nbArticle"] = $nbArticle[0];

//compte le nombre de commentaie écrit par l'utilisteur
$requete3 = "SELECT count(*) FROM commentaire WHERE auteur = :id";
$res3 = $bd->prepare($requete3);
$res3->execute( array(
	":id" => $id
));
$nbCom = $res3->fetch();
$resultat["nbCom"] = $nbCom[0];
 ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<script src="../Style/js/bootstrap.js"></script>
		<link rel="stylesheet" href="../Style/css/bootstrap.css"  />
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="../Style/jquery/jquery.min.js"></script>
		<title> <?php echo $resultat['userName']; ?> </title>
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
										<img class='img-thumbnail rounded-circle' src='" . $resultat['image'] . "' alt='image du profil de " .$resultat['userName'] . "'>
									</div>

									<div class = 'col-9'>
										<p id='user'> Nom d'utilistaeur : " . $resultat['userName'] . "</p>
										<p id='mail'> Mail : " . $resultat['mail'] . "</p>
										<p id='tel'> Téléphone : " . $resultat['tel'] . "</p>
										<p id='nbArticle'> Nombre d'article écrit : ". $resultat['nbArticle']." </p>
										<p id='nbCom'> Nombre de commentaire écrit :". $resultat['nbCom'] ."</p>
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
