<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Stats</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<?php
	include("./header.php");
	?>
	<div class="main2">
		<img src="./images/analysis.png">
		<h2>Veuillez consulter les statistique des étudiants </h2>
		<br>
		<br>
		<?php
		include "connexion.php";
		//étudiants évalués
		$evalue = $conn->prepare(
			"SELECT count(*) as totaleEvalue  FROM etudiant"
		);
		$evalue->execute();
		$resultat1 = $evalue->fetch(PDO::FETCH_ASSOC);
		echo $resultat1["totaleEvalue"] . " étudiants ont été évalués<br><br>";
		//étudiants réussi
		$reussi = $conn->prepare(
			"SELECT count(*) as totaleReussi  FROM etudiant
			where moyenne >= 12
		"
		);
		$reussi->execute();
		$resultat2 = $reussi->fetch(PDO::FETCH_ASSOC);
		echo $resultat2["totaleReussi"] . " étudiants ont été réussi<br>";

		//taux réussi en ligne
		$typeEnLigne = "En ligne";
		echo "<br>Le taux de réussite en ligne est " . totalEtudiant($conn, $typeEnLigne) . "%<br><br>";
		//taux réussi en classe
		$typeEnClasse = "En classe";
		echo "Le taux de réussite en classe est " . totalEtudiant($conn, $typeEnClasse) . "%<br><br>";
		//taux réussi en Hybride
		$typeEnHybride = "Hybride";
		echo "Le taux de réussite en Hybride est " . totalEtudiant($conn, $typeEnHybride) . "%<br><br>";
		function totalEtudiant($conn, $type)
		{

			$EtudiantReussi = $conn->prepare(
				"SELECT COUNT(*) as  EtudiantReussi FROM etudiant
			RIGHT JOIN groupe
			on codeGroupe = code
			WHERE moyenne >= 12 and type = '$type'"
			);
			$EtudiantReussi->execute();
			$resultat = $EtudiantReussi->fetch(PDO::FETCH_ASSOC);

			$totalEtudiant = $conn->prepare(
				"SELECT COUNT(*) as totalEtudiant FROM etudiant
			RIGHT JOIN groupe 
			on codeGroupe = code
			WHERE type = '$type'"

			);
			$totalEtudiant->execute();
			$resultat2 = $totalEtudiant->fetch(PDO::FETCH_ASSOC);

			$porcentage = ($resultat["EtudiantReussi"] / $resultat2["totalEtudiant"]) * 100;

			return number_format($porcentage, 2);
		}
		?>
	</div>
	<?php
	include("./footer.php");
	?>
</body>