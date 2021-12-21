<?php
//menu utilistauer non connectés
if(!key_exists('id',$_SESSION)){
	$menu ="
		<nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
			<div class = 'container-fluid'>
				<a class='navbar-brand' href='..'>login</a>
			</div>
		</nav>
	";
}
//menu utilistauers connectésf403
else{
	$menu ="
		<nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
			<div class = 'container-fluid'>
				<a class='navbar-brand' href='../Profil/myprofil.php'>Mon profil</a>
				<div class='collapse navbar-collapse' id='navbarNav'>
					<ul class='navbar-nav'>
						<li class='nav-item'>
							<a class='navbar-brand' href='../ProfilListe/listeProfil.php'>Liste des profils</a>
						</li>
					</ul>
					<button class='btn btn-outline-danger' id='deco'> Déconnexion</button>
				</div>
			</div>
		</nav>
	";
}
 ?>

</script>
