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

//selection de l'image et du nom d'utilisateur
$requeteUser =  "SELECT userName, image FROM utilisateur WHERE id = :id";
$resUser = $bd->prepare($requeteUser);
$resUser->execute(array(
	":id" => $_SESSION['id']
));
$resultatUser =$resUser->fetch();

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
					<table class="table table-success text-center align-middle">
						<tr>
							<td width="200px">
								<figure>
									<img src="<?php echo $src?>" alt="image de profil" width='100px;' class="rounded-circle" >
									<?php echo ("<figcaption><a href='../Profil/profil.php?id=".$resultatAut['id']."'>".$_GET['auteur']."</a></figcaption>");
								echo("</figure>");
							echo("</td>");
							echo("<td>");
								//si l'utilisateur connecté est l'auteur de l'article, on va affiché les boutons de créations et de suppression d'article
								if($_SESSION['id'] == $resultatArt['auteur'] ){
									echo ("<a href='editArticle.php?id=".$_GET['id']."&auteur=".$resultatAut['id']."'><button class='btn btn-warning'> Modifier article</button></a>");
									echo ("<button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#delModal'> Supprimer l'article</button>");
								}

							?>
							</td>
						</tr>
					</table>

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

					<table class="table table-dark table-striped text-center align-middle">
						<thead>
							<th width="200px">Utilisateur</th>
							<th>Commentaire</th>
						</thead>
						<tbody id="comments">
						</tbody>
					</table>
					<button class="btn btn-info" id="rafrai"> raffraichir les commentaires </button>
				</div>

				<div id="newComment" class="border border-dark" >
					<h2 class='border-bottom' > Poster votre commentaire</h2>
					<table class="table bg-info text-center align-middle">
						<tr>
							<!--Affichage de l'image de profil et du nom de l'utilisateur connecté qui va posté un com -->
							<td width="200px">
								<figure>
								<?php
								echo ("<img class='rounded-circle' width='100px' src ='".$resultatUser['image']."' alt='image de profil de ".$resultatUser['userName']."' >");
								echo ("<figcaption>".$resultatUser['userName']."</figcaption>");
								 ?>
							 	</figure>
							</td>
							<!--Formulaire où on écrit son commentaire et le poste -->
							<td>
								<form onsubmit="return addCommentaire()" method="POST">
									<div class='form-group col'>
										<textarea class="form-control z-depth-1" rows="10" id="contenu" name="contenu"></textarea>
										<p class='err' id='errContenu' > </p>
									</div>
									<div class='form-group col'>
										<input class="btn btn-dark" type="submit" id='addCom' name='addCom' value='Publier votre commentaire'>
									</div>
								</form>
							</td>
						</tr>
					</table>

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

			<!-- Modal de suppression de commentaire-->
			<div class="modal fade" id="delComModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content bg-dark text-light">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Suppression de commentaire</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<p> Voulez-vous vraiment supprimer votre commentaire?</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" id="confirmDelCom" data-bs-dismiss="modal">Supprimer mon commentaire</button>
							<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
						</div>
					</div>
				</div>
			</div>
			<!-- Modal d'édition de commentaire -->
			<div class="modal fade" id="editComModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content bg-dark text-light">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Modification d'article</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form>
								<textarea class="form-control z-depth-1" rows="10" id="comEdit" name="comEdit"></textarea>
								<p class='err' id='errComEdit' > </p>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" id="confirmEditCom" data-bs-dismiss="modal">Modifier mon commentaire</button>
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

	//affiche les commentaire
	function refreshCom(){
		let auteur  = <?php echo $_SESSION['id']?>;
		let article = <?php echo $_GET['id']?>;
		//vide la table des com
		$('#comments').empty();
		//charge les commentaire lié à l'article
		let ajax = new XMLHttpRequest();
		ajax.open("POST", "../Commentaire/getAllCom.php", true);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("article="+article);
		ajax.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				let data = JSON.parse(this.responseText);

				let html = "";
				for (let a = 0; a < data.length; a++) {

					html += "<tr id='" + data[a].id + "'>";
						//image + pseudo
						html += "<td> <figure>";
						html += "<img class='rounded-circle' width='100px' src='"+data[a].image+"'>";
						html += "<figcaption><a href='../Profil/profil.php?id="+data[a].auteur+"'>"+data[a].userName+"</a></figcaption>";
						//bouton de suppression si c'est le bon utilisateur de connecter
						if(auteur == data[a].auteur ){
							html += "<div><button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#delComModal' data-bs-id='" + data[a].id + "'> Supprimer votre commentaire </button> </div>";
							html += '<div><button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editComModal" data-bs-id="' + data[a].id + '" data-bs-com="' + data[a].contenu + '"> Modifier votre commentaire </button> </div>';
						}
						html += "</figure></td>";
						//commentaire
						html += "<td>" + data[a].contenu + "</td>";
					html += "</tr>";
				}

				document.getElementById("comments").innerHTML += html;
			}
		};
	}
	//appelle de la fonction chargeant les com
	refreshCom();

	//ajout de la fonction raftaichir les commentaire aux boutons portant ce nom
	$('#rafrai').click(function(){
		refreshCom();
	})

	//suprresion des com
	//selection du bouton de suppresion de com + affichage modal
	let delCom = document.getElementById('delComModal');
	delCom.addEventListener('show.bs.modal',function(event){
		let buttonDelCom = event.relatedTarget;
		//lie fonction suppresion de com à bouton validataion de suppression
		$('#confirmDelCom').click(function(){
			//récupère l'id du commentaire
			let id = buttonDelCom.getAttribute('data-bs-id');
			//supprime le commentaire en appellant la fonction deleteCom
			deleteCom(id);
		});
	});

	//fonction supprimant le commentaires choissis
	function deleteCom(id){
		let ajax = new XMLHttpRequest();
		ajax.open("POST", "../Commentaire/deleteCom.php", true);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send( "id=" + id);
		ajax.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				//alerte confirmant la suppresion et redirection vers la liste des articles
				alert("suppression réussi");
				//raffrachit la page
				location.reload();
			}
		}
		return false;
	}
	//édition des com
	//selection bouton + affichage modal
	let editCom = document.getElementById('editComModal');
	editCom.addEventListener('show.bs.modal',function(event){
		let buttonDelCom = event.relatedTarget;
		//récupère le com et l'ajoute au Formulaire
		let com = buttonDelCom.getAttribute("data-bs-com");
		$('#comEdit').html(com);
		//lie fonction suppresion de com à bouton validataion de suppression
		$('#confirmEditCom').click(function(){
			//récupère l'id du commentaire
			let id = buttonDelCom.getAttribute('data-bs-id');
			//appelle la fonction d'édition de commentaire
			editionCom(id);
		});
	});

	//Fonction d'édition de commentaire
	function editionCom(id){
		//récupère le com
		let com = document.getElementById("comEdit").value;
		//si le com n'est pas vide, appelle script php
		if(com != ""){
			let ajax = new XMLHttpRequest();
			ajax.open("POST", "../Commentaire/editCom.php", true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.send( "id=" + id + "&com=" + com);
			ajax.onreadystatechange = function () {
				if (this.readyState == 4 && this.status == 200) {
					//alerte confirmant la suppresion et redirection vers la liste des articles
					alert("modification réussi");
					//refraichit les com
					location.reload();
				}
			}
		}
		else{
			alert("Vous avez mis un commentaire vide, la modifcation n'a pas été prise en compte");
			location.reload();
		}
		return false;
	}

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

	//ajout d'un commentaire
	function addCommentaire(){
		//récupère le contenu du commentaire et l'identifiant de l'article
		let com = document.getElementById("contenu").value;
		let article = <?php echo $_GET['id'];?>;
		//message d'erreur
		if(com == ""){
			$('#errContenu').text("Vous n'avez pas mis de contenu dans votre commentaire!");
		}
		else{
			$('#errContenu').text("");
			let ajax = new XMLHttpRequest();
			ajax.open("POST", "../Commentaire/addCom.php" ,true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.send( "com=" + com + "&article=" + article);
			ajax.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				//alerte confirmant la suppresion et redirection vers la liste des articles
				alert("Commentaire ajouté!");
				}
			}
		}
		//rafraichit la table de commentaire pour ajouter le nouveau commentaire et rafraichir la table
		refreshCom();
		return false;
	}

</script>
