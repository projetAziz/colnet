<?php
session_start();
include("./connexion.php");
if (isset($_POST["submit"])) {
	try {
		//Préparation des données
		$nomComplet = $_POST["nomComplet"];
		$username = $_POST["username"];
		$codePostal = $_POST["codePostal"];
		$email = $_POST["email"];
		$motDePasse = $_POST["motDePasse"];
		//Création de la requete préparée
		$insertionUtilisateur = $conn->prepare(
			"INSERT INTO utilisateur (nomComplet, username, codePostal, email, motDePasse)
			VALUES (:nomComplet, :username, :codePostal, :email, :motDePasse)"
		);
		//Liaison des valeurs avec les marqueurs
		$insertionUtilisateur->bindParam(':nomComplet', $nomComplet);
		$insertionUtilisateur->bindParam(':username', $username);
		$insertionUtilisateur->bindParam(':codePostal', $codePostal);
		$insertionUtilisateur->bindParam(':email', $email);
		$insertionUtilisateur->bindParam(':motDePasse', $motDePasse);
		//Éxécution de requete
		$insertionUtilisateur->execute();
		$_SESSION["status"] = "<div class='isa_success'><i class='fa fa-check'></i>Votre compte été créee, vous pouvez vous <a href='./login.php'> Se connecter</a></div>";
	} catch (PDOException $error) {
		$message = "<div class='isa_error'><i class='fa fa-times-circle'></i>Erreur: " . $error->getMessage() . "</div>";
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Compte</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>

	<div id="contentwrapper">
		<div id="content">
			<div class="h">
				Colnet Collége O'sullivan.

				<p class="pr">Veuillez Créer un compte</p>
			</div>

			<?php
			echo $message;
			if (isset($_SESSION["status"])) {
				echo $_SESSION["status"];
				unset($_SESSION["status"]);
			}
			?>
			<form action="./compte.php" method="post">
				<div id="rightbod">
					<a href=""><img src="./images/icons-create.png" class="icon"></a>
					<div class="signup bolder">S'inscrire</div>
					<div class="free bolder">CONNEXION - PORTAIL DU COLLÈGE</div>
					<div class="formbox">
						<input type="text" class="txt" placeholder="Nom complet" name="nomComplet" required
							pattern="^[A-Za-z\s-]{1,30}$">
						<input type="text" class="txt" placeholder="Username" name="username" required
							pattern="^[A-Za-z\s-]{1,30}$">
					</div>
					<div class="formbox">
						<input type="text" class="txt" placeholder="Code Postal" name="codePostal" required
							pattern="[A-Za-z][0-9][A-Za-z] [0-9][A-Za-z][0-9]">
					</div>
					<div class="formbox">
						<input type="text" class="txt"" placeholder=" Email" name="email" required
							pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,50}$">
					</div>
					<div class="formbox">
						<input type="password" class="txt"" placeholder=" Mot de passe" name="motDePasse" required
							pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2, 30}$">
					</div>
					<div class="formbox">
						<button type="submit" class="login-btn" name="submit">S'inscrire</button>
					</div>
				</div>
			</form>

		</div>
	</div>

	<?php
	include("./footer.php")
	?>
</body>