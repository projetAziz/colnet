<?php

session_start();
include "connexion.php";

if (isset($_POST["submit"])) {
	$username = $_POST["username"];
	$motDePasse = $_POST["motDePasse"];
	$login = $conn->prepare(
		"SELECT count(*) as resultat   FROM utilisateur
                where username = '$username' and motDePasse = '$motDePasse'"
	);
	$login->execute();
	$resultat = $login->fetch(PDO::FETCH_ASSOC);
	if ($resultat["resultat"] == 1) {
		$_SESSION["status"] = "
		<div class='isa_success'>
			<i class='fa fa-check'></i>
			Crédentiels valides, vous pouvez accéder à l'<a href='./accueil.php'>Acceuil</a>
		</div>";
	} else if ($resultat["resultat"] == 0) {
		$_SESSION["status"] =
			"<div class='isa_error'><i class='fa fa-times-circle'></i>
			Username ou mot de passe incorect 
		</div>";
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div class="h1">
		<h1 class="h">Colnet Collége O'sullivan.</h1>
		<p class="pr">Veuillez vous connecter</p>
	</div>

	<form class="main" method="post" action="">
		<img src="./images/icons-login.png" class="icon">
		<input type="text" placeholder="Nom d'utilisateur" class="txt" name="username" required><br>
		<input type="password" placeholder="Mot de passe" class="txt" name="motDePasse" required><br>
		<input type="submit" value="Se connecter" class="login-btn" name="submit"><br>
		<input type="button" value="Créer un compte" class="login-btn" onclick="location.href='./compte.php'">

	</form>
	<?php
	if (isset($_SESSION["status"])) {
		echo  $_SESSION["status"];
		unset($_SESSION["status"]);
	}
	?>
	<?php
	include("./footer.php")
	?>
</body>

</html>