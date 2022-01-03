<?php
include "../Commun/connexion.php";
include "../Commun/footer.php";
include "../Commun/menu.php";

//redirection vers page de connexion si pas connecté
if(!key_exists('id', $_SESSION)){
	header("Location: ..");
}

//réucpère les infos sur l'article
$requeteArt = "SELECT titre, contenu, auteur FROM article WHERE id = :id";
$resArt = $bd->prepare($requeteArt);
$resArt->execute(array(
	":id" => $_GET['id']
));
$resultatArt = $resArt->fetch();

//selection de l'image de l'auteur
$requeteAut = "SELECT id, image FROM utilisateur WHERE userName = :userName";
$resAut = $bd->prepare($requeteAut);
$resAut->execute(array(
	":userName" => $_GET['auteur']
));
$resultatAut =$resAut->fetch();

 ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<script src="../Style/js/bootstrap.js"></script>
		<link rel="stylesheet" href="../Style/css/bootstrap.css"  />
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="../Style/jquery/jquery.min.js"></script>
		<title> <?php echo $resultatArt['titre']; ?> </title>
	</head>

	<body class="bg-dark">

		<?php echo $menu;?>

		<main class="bg-light" >
			<div class = "container">

				<div id='auteur' class='border border-dark '>
					<h2 class='border-bottom'> Auteur :</h2>
					<!-- affiche l'image et le nom de l'auteur -->
					<?php $src = $resultatAut['image']; ?>
					<img src="<?php echo $src?>" alt="image de profil" width='100px;'class="rounded-circle" >
					<?php echo $_GET['auteur'];
					//si l'utilisateur connecté est l'auteur de l'article, on va affiché les boutons de créations et de suppression d'article
					if($_SESSION['id'] == $resultatArt['auteur'] ){
						echo ("<a href='editArticle.php?id=".$_GET['id']."&auteur=".$resultatAut['id']."'><button class='btn btn-warning'> Modifier article</button></a>");
						echo ("<button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#delModal'> Supprimer l'article</button>");
					}

					?>

				</div>

				<div id = 'article' class='border border-dark'>
					<?php
					//afiche l'article
					echo "<h2 class='border-bottom'> Titre : ".$resultatArt['titre']."</h2>";
					echo $resultatArt['contenu'];
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

			<!-- Modal de suppresion d'article -->
			<div class="modal fade" id="delModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content bg-dark text-light">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Suppression d'article</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<p> Voulez-vous vraiment supprimer votre article?</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" id="confirmDel" data-bs-dismiss="modal">Supprimer mon article</button>
							<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
						</div>
					</div>
				</div>
			</div>

		</main>

		<?php echo $footer;?>
	</body>
</html>

<script>

	//partie modification de l'article

	//partie suppresion de l'article
	//bouton suppression faisant apparaitre modal de suppresion de profil
	let delArticle = document.getElementById('delModal');
	delArticle.addEventListener('show.bs.modal', function (event) {
		//lien bouton suppression de la modal de suppression - fonction suppression
		$('#confirmDel').click(function(){
			suppression();
		});

	})
	//fonction supprimant l'article après avoir récupérer son id
	function suppression(){
		//récupère id de l'article
		let idArticle = <?php echo $_GET['id']?>;

		//requete envoyer lorsque l'on confirme la suppresion de l'article
		let ajax = new XMLHttpRequest();
		ajax.open("POST", "deleteArticle.php", true);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send( "idArt=" + idArticle);
		ajax.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				//alerte confirmant la suppresion et redirection vers la liste des articles
				alert("suppression réussi");
				document.location.href="/Article/listeArticle.php";
			}
		}
	}

</script>
