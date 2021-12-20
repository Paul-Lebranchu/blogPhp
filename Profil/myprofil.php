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
				<?php
					//bouton pour se déconnecter
					if(key_exists('id', $_SESSION)){
						 echo("<button class='btn btn-danger' id='deco'> Déconnexion </button>");
					}
				?>
				<h1> Mon Profil </h1>
				<?php
				if(key_exists('id', $_SESSION)){
					echo $_SESSION['id'];
				}
				else{
					echo "vous n'avez pas le droit d'être là";
				}
				 ?>
			</div>
		</main>
		<?php echo $footer;?>
	</body>
</html>

<script>
$("#deco").click(function(){
	alert("déconnexion en cours de création");
})
</script>
