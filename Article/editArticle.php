<?php
include "../Commun/connexion.php";
include "../Commun/footer.php";
include "../Commun/menu.php";

//redirection vers page de connexion si pas connecté
if(!key_exists('id', $_SESSION)){
	header("Location: ..");
}
//redirection vers la page des articles si l'on tente de modifer un article qui n'est pas le notre
if($_SESSION['id'] != $_GET['auteur']){
	header("Location: listeArticle.php");
}

//selectionne le contenu et le titre de l'article
$requete = "SELECT titre, contenu FROM article WHERE id = :id";
$res = $bd->prepare($requete);
$res->execute(array(
	":id" => $_GET['id']
));
$resultat = $res->fetch();

$titre = $resultat['titre'];
$contenu = $resultat['contenu'];
 ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<script src="../Style/js/bootstrap.js"></script>
		<link rel="stylesheet" href="../Style/css/bootstrap.css"  />
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="../Style/jquery/jquery.min.js"></script>
		<script src="../Style/jquery/RichText/jquery.richtext.min.js"></script>
		<link rel="stylesheet" href="../Style/jquery/RichText/richtext.min.css">
		<title> <?php echo "Modifier votre article" ?> </title>
	</head>

	<body class="bg-dark">

		<?php echo $menu;?>

		<main class="bg-light" >
			<div class = "container">

				<h1> Modifier votre article! </h1>

				<form onsubmit='return editArticle()'>
					<div class='form-group col'>
						<label for='titre'> Titre de l'article </label>
						<input type="texte" id='titre' name='titre' value = "<?php echo $titre; ?>">
						<p class='err' id='errTitre' > </p>
					</div>
					<div class='form-group col'>
						<label for='contenu'> Contenu article </label>
						<textarea class = "contenu" id="contenu" name="contenu" rows="5" cols="33"><?php echo $contenu; ?></textarea>
						<p class='err' id='errContenu' > </p>
					</div>
					<div class='form-group col'>
						<input class='btn btn-primary' type='submit' value="Modifer un article">
					</div>
				</form>

			</div>
		</main>

		<?php echo $footer;?>
	</body>
</html>

<script>
$('.contenu').richText();

//function gérant l'envoi du nouvel article
function editArticle(){

	//récupère le contenu des différents champs et l'id de l'auteur
	let titre = document.getElementById("titre").value;
	let contenu = document.getElementById("contenu").value;
	let id = <?php echo $_GET['id'];?>
	//vérifie que les champs soit pas vide
	let formOk = 1;
	if(titre == ""){
		$('#errTitre').text("Vous n'avez pas renseigné de titre!");
		formOk = 0;
	}else{
		$('#errTitre').text("");
	}

	if(contenu == "<div><br></div>"){
		$('#errContenu').text("Vous n'avez pas mis de contenu dans votre article!");
		formOk = 0;
	}else{
		$('#errContenu').text("");
	}

	if(formOk == 1){
		let ajax = new XMLHttpRequest();
		ajax.open("POST", "articleEdition.php", true);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("titre=" + titre + "&contenu=" + contenu + "&id=" + id);
		ajax.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				alert("Article correctement modifié");
				document.location.href="listeArticle.php";
			}
		}
	}
	return false;
}
</script>
