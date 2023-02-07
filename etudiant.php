<?php
session_start();
include("./connexion.php");
if (isset($_POST["submit"])) {
	try {

		//Préparation des données
		$codePermanent = $_POST["codePermanent"];
		$nomComplet = $_POST["nomComplet"];
		$adresse = $_POST["adresse"];
		$telephone = $_POST["telephone"];
		$moyenne = $_POST["moyenne"];
		$codeGroupe = $_POST["codeGroupe"];
		//Création de la requete préparée
		$ajouterEtudiant = $conn->prepare(
			"INSERT INTO etudiant (codePermanent, nomComplet, adresse, telephone,moyenne,codeGroupe)
			VALUES (:codePermanent,:nomComplet, :adresse, :telephone,:moyenne,:codeGroupe)"
		);
		//Liaison des valeurs avec les marqueurs
		$ajouterEtudiant->bindParam(':codePermanent', $codePermanent);
		$ajouterEtudiant->bindParam(':nomComplet', $nomComplet);
		$ajouterEtudiant->bindParam(':adresse', $adresse);
		$ajouterEtudiant->bindParam(':telephone', $telephone);
		$ajouterEtudiant->bindParam(':moyenne', $moyenne);
		$ajouterEtudiant->bindParam(':codeGroupe', $codeGroupe);
		//Éxécution de requete 
		$ajouterEtudiant->execute();
		echo "
		<div class='isa_success'>
			<i class='fa fa-check'></i>L'Étudiant(e) " . $nomComplet . " a été ajouté(e) avec succès <a href='./accueil.php'>Acceuil</a>
		</div>";
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
	<title>étudiant</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div class="h1">
		<h1 class="h">Colnet Collége O'sullivan.</h1>
		<p class="pr">Ajouter un étudiant</p>
	</div>

	<?php
	echo $message;
	?>
	<form class="main-student" method="post" action="./etudiant.php">
		<a href=""><img src="./images/add-user.png" class="icon"></a>
		<input type="text" placeholder="Code Permanent" class="txt" name="codePermanent" required
			pattern="[A-Z]{4}[0-9]{6}"><br>
		<input type="text" placeholder="Nom Complet" class="txt" name="nomComplet" required
			pattern="^[A-Za-z\s-]{1,50}$"><br>
		<input type="text" placeholder="Adresse" class="txt" name="adresse" required pattern="^[A-Za-z0-9\s-]{1,30}$"><br>
		<label for="">Téléphone</label><br>
		<input type="text" class="txt" name="telephone" required pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
			placeholder="___-___-____"><br>
		<input type="text" placeholder="Moyenne" class="txt" name="moyenne" required pattern="[0-9]{1,2}"><br>
		<div class="select">
			<label for="">Choisir un groupe</label>
			<?php

			$codeGroupe = $conn->prepare(
				"SELECT DISTINCT code FROM groupe"
			);
			$codeGroupe->execute();
			$groupe = $codeGroupe->fetchAll(PDO::FETCH_ASSOC);
			?>
			<select id="standard-select" class="txt" name="codeGroupe">
				<?php
				for ($i = 0; $i < count($groupe); $i++) {
				?>
				<option value="<?php echo $groupe[$i]["code"] ?>">
					<?php
						echo $groupe[$i]['code'];
						?>
				</option>
				<?php
				}
				?>
			</select>
		</div>
		<input type="submit" value="Ajouter" class="login-btn" name="submit"><br>
	</form>
	<?php
	include("./footer.php")
	?>
</body>

</html>