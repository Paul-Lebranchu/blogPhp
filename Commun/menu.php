<?php
//menu utilistauer non connectés
if(!key_exists('id',$_SESSION)){
	$menu ="
		<nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
			<div class = 'container-fluid'>
				<a class='navbar-brand' href='..'>Login</a>
			</div>
		</nav>
	";
}
//menu utilistauers connectés
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
						<li class='nav-item'>
							<a class='navbar-brand' href='../Article/listeArticle.php'>Articles</a>
						</li>
					</ul>
					<button class='btn btn-outline-danger' id='deco' onclick='deconnexion()'> Déconnexion</button>
				</div>
			</div>
		</nav>
	";
}
 ?>

<script>

function deconnexion(){
	//supression de la variable session id
	let ajax = new XMLHttpRequest();
	ajax.open("GET", "../Inscription_Connexion/deconnexion.php", true);
	ajax.send();

	ajax.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			//alerte de redirection vers la page d'accueil
			alert("Vous avez été déconnectez, vous allez être redirigé vers la page de connexion");
			//redirection
			document.location.href="../";
		}
	}
}

</script>
