<?php
session_start();
include("./connexion.php");
if (isset($_POST["submit"])) {
	try {
		//Préparation des données
		$code = $_POST["code"];
		$nom = $_POST["nom"];
		$type = $_POST["type"];
		//Création de la requete préparée
		$ajouterGroupe = $conn->prepare(
			"INSERT INTO groupe (code, nom, type)
				VALUES (:code, :nom, :type)"
		);
		//Liaison des valeurs avec les marqueurs
		$ajouterGroupe->bindParam(':code', $code);
		$ajouterGroupe->bindParam(':nom', $nom);
		$ajouterGroupe->bindParam(':type', $type);
		//Éxécution de requete
		$ajouterGroupe->execute();

		$_SESSION["status"] =  "le groupe " . $code . " a été ajouter avec succès ";
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
	<title>Ajouter groupe</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div class="h1">
		<h1 class="h">Colnet Collége O'sullivan.</h1>
		<p class="pr">Ajouter un groupe</p>

		<?php
		echo $message;
		?>
	</div>
	<form class="main" method="post">
		<a href=""><img src="./images/icon-add.png" class="icon"></a>
		<input type="text" placeholder="Code" class="txt" name="code" required pattern="^[A-Z0-9]{1,7}$"><br>
		<input type="text" placeholder="Nom" class="txt" name="nom" required pattern="^[A-Za-z0-9\s-]{,50}$"><br>
		<div class="select">
			<label for="">Choisir un type</label>
			<select id="standard-select" class="txt" name="type">
				<option value="En ligne">En ligne</option>
				<option value="En classe">En classe</option>
				<option value="Hybride">Hybride</option>
			</select>
		</div>
		<input type="submit" value="Ajouter" class="login-btn" name="submit"><br>
	</form>
	<?php
	if (isset($_SESSION["status"])) {
		echo "
	<div class='isa_success'>
		<i class='fa fa-check'></i>" . $_SESSION["status"] . "<a href='./accueil.php'>Acceuil</a>
	</div>";
		unset($_SESSION["status"]);
	}
	?>
	<?php
	include("./footer.php")
	?>
</body>

</html>