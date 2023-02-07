<?php

include "connexion.php";
$afficherAll = $conn->prepare(
	"SELECT  *  FROM etudiant"
);
$afficherAll->execute();
$resultat = $afficherAll->fetchall(PDO::FETCH_ASSOC);
if (isset($_POST["submit"])) {
	$code = $_POST["codeGroupe"];
	$triMoyenne = $_POST["triMoyenne"];
	if ($triMoyenne == "Descendant") {
		$afficher = $conn->prepare(
			"SELECT  *  FROM etudiant
									where codeGroupe = '$code'
									ORDER BY moyenne DESC"
		);
	} else if ($triMoyenne == "Ascendant") {
		$afficher = $conn->prepare(
			"SELECT  *  FROM etudiant
									where codeGroupe = '$code'
									ORDER BY moyenne  ASC"
		);
	}
	$afficher->execute();
	$resultat = $afficher->fetchall(PDO::FETCH_ASSOC);
}

//supprimer Étudiant
if (isset($_POST["supprimer"])) {
	$codePermanent = $_POST["supprimer"];
	$supprimerRow = $conn->prepare(
		"DELETE FROM etudiant
								where codePermanent = '$codePermanent'"
	);
	$supprimerRow->execute();

	echo "
	<div class='isa_success'>
		<i class='fa fa-check'></i>L'Étudiant avec le code permanent :" . $codePermanent . ", a été supprimer avec succès
	</div>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Afficher</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div class="h1">
		<h1 class="h">Colnet Collége O'sullivan.</h1>
		<p class="pr">Veuille apliquer vos filltre</p>
	</div>
	<div class="row">
		<div class="col5">
			<form class="main" method="post">
				<a href=""><img src="./images/filter.png" class="icon"></a>
				<div class="select">
					<label for="">Choisir un groupe</label>
					<?php

					$codeGroupe = $conn->prepare(
						"SELECT code FROM groupe"
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
					<br>
					<label for="">Tri sur le moyanne</label>
					<select id="standard-select" class="txt" name="triMoyenne">
						<option value="Descendant">Descendant</option>
						<option value="Ascendant">Ascendant</option>
					</select>
				</div>
				<input type="submit" value="Aficher Résultats" class="login-btn" name="submit"><br>
			</form>
			<br>
			<div class='isa_success'>
				<h3>Revenir a <a href="./accueil.php">l'acceuil</a></h3>
			</div>
		</div>
		<div class="col5">
			<table>
				<thead>
					<tr>
						<th>Code Permanent</th>
						<th>Nom Complet</th>
						<th>Téléphone</th>
						<th>moyenne</th>
						<th>Code Groupe</th>
						<th>Supprimer</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($resultat as $key) {
					?>
					<tr>
						<td><?php echo $key['codePermanent']; ?></td>
						<td><?php echo $key['nomComplet']; ?></td>
						<td><?php echo $key['telephone']; ?></td>
						<td><?php echo $key['moyenne']; ?></td>
						<td><?php echo $key['codeGroupe']; ?></td>
						<td>
							<form method="post">
								<button name="supprimer" value="<?php echo $key['codePermanent']; ?>">Supprimer
								</button>
							</form>

						</td>
					</tr>

					<?php
					}
					?>

				</tbody>
			</table>

		</div>
	</div>
	<?php
	include("./footer.php");
	?>
</body>

</html>