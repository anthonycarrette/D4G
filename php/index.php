<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=D4G;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Team 4 - DESIGN4GREEN 2020</title>
		<meta charset="UTF-8">
		<link rel="icon" href="D4G.png" />

		<script type="text/javascript" src="pdf.js"></script>
		<script src="html2canvas.js"></script>
		<script src="jquery-3.5.1.min.js"></script>
		<script src="jspdf.min.js"></script>

		<style>
			body{
				display: flex;
				flex-direction: column;
			}
			.titre{
				text-align: center;
				background-color: #A2BF8E;
			}
			.formulaire{
				display: flex;
				justify-content: center;
			}
			form{
				border: solid 1px gray;
				width: 30%;
				text-align: center;
				margin-bottom: 10px;
			}
			form select{
				margin-top: 10px;
				margin-bottom: 10px;
			}
			table
			{
				border-collapse: collapse;
			}
			th,td
			{
				border: 1px solid black;
				text-align: center;
				width: 200px;
			}
            #search
            {
                margin-bottom: 10px;
            }
			footer
			{
				position: absolute; 
				bottom: 0;
			}
		</style>
	</head>
	
	<body>
		<div>
			<h1 class="titre">Team 4 - DESIGN4GREEN 2020</h1>

			<h2>L'indice de fragilité numérique</h2>
			<p align="justify">
				L'indice de fragilité numérique révèle les zones d'exclusion numérique sur un territoire donné.
				Cet outil permet, que vous soyez une commune, un département ou une région de comparer votre indice de fragilité numérique avec les autres territoires.
				Il peut être associé à une représentation graphique afin d'aider la visualisation (ce ne sera pas le cas ici).
			</p>
			<p align="justify">
				À ce jour, cet indice se compose de quatre indicateurs qui permettent de créer une analyse globale. 
				Les deux premiers sont l'accès à l'information et aux interfaces numériques.
				Les deux autres sont les compétences utilisation d'une interface et les compétences administratives.
			</p>
			<div class="formulaire">
				<form action="index.php" method="post">
					<p>Chercher une commune par : </p>
					<label for="CP">Code Postal</label>
					<?php
						if (isset($_POST['CP']) AND $_POST['CP'] != "") {
							$CP = $_POST['CP'];
							echo '<input type="text" name="CP" id="CP" value="' . $CP . '">';
						} else {
							echo '<input type="text" name="CP" id="CP" value="">';
						}
					?>
					<?php
						if (isset($_POST['CP']) AND $_POST['CP'] != "") {
							echo '
							<br>
							<label for="NomCommune">Nom de commune</label>
							<select name="NomCommune" id="NomCommune">';
							$CP = $_POST['CP'];
							$req = $bdd->prepare('SELECT CDR.NomCom FROM CDR WHERE CDR.CP = :CP;');
							$req->execute(array(
							'CP' => $CP ));
							while ($donnees = $req->fetch()){
								if (htmlspecialchars($donnees['NomCom']) == $_POST['NomCommune']){
									echo '<option value="' . htmlspecialchars($donnees['NomCom']) . '" selected>' . htmlspecialchars($donnees['NomCom']) . '</option>';
								} else {
									echo '<option value="' . htmlspecialchars($donnees['NomCom']) . '">' . htmlspecialchars($donnees['NomCom']) . '</option>';
								}
							}
							$req->closeCursor();
						}
					?>
					</select>
					<br>
					<input type="submit" id ="search" value="Rechercher" />
				</form>
			</div>
			
			<?php
				if (isset($_POST['NomCommune']) AND $_POST['NomCommune'] != "") { 
					$Com = $_POST['NomCommune'];
					$CP = $_POST['CP'];

					echo '<table id="content">
					<tr><th rowspan="2">Code Postal</th><th colspan="3">Commune</th><th colspan="2">Accès</th><th colspan="2">Compétences</th><th rowspan="2">Score Global Commune</th><th rowspan="2">Score Global Région</th></tr>
					<tr><td>Nom</td><td>Nom Iris</td><td>Population</td><td>Accès aux interfaces numériques</td><td>Accès à l\'information</td><td>Compétences administratives</td><td>Compétences numériques/scolaires</td></tr>';
					
					$req = $bdd->prepare('SELECT count(*) as numbers FROM `Records` WHERE NomCom LIKE :Com and CodePostal = :CP;');
					$req->execute(array(
						'Com' => $Com,
						'CP' => $CP,
					));

					$donnees = $req->fetch();
					if ($donnees['numbers'] != 0) {
						$req = $bdd->prepare('SELECT * FROM `Records` WHERE NomCom LIKE :Com AND CodePostal = :CP;');
						$req->execute(array(
						'Com' => $Com,
						'CP' => $CP,
					));
						while ($donnees = $req->fetch()){
							echo '<tr><td>' . htmlspecialchars($donnees['CodePostal']) . '</td><td>' . htmlspecialchars($donnees['NomCom']) . '</td><td>' . htmlspecialchars($donnees['NomIris']) . '</td><td>' . htmlspecialchars($donnees['Populations']) . '</td><td>' . htmlspecialchars($donnees['AccesInterfaceNum']) . '</td><td>' . htmlspecialchars($donnees['AccesInfo']) . '</td><td>' . htmlspecialchars($donnees['CompAdmin']) . '</td><td>' . htmlspecialchars($donnees['CompNum']) . '</td><td>' . htmlspecialchars($donnees['ScoreCom']) . '</td><td>' . htmlspecialchars($donnees['ScoreReg']) . '</td></tr>';
						}

					} else {
						$req = $bdd->prepare('SELECT CDR.CP, CDR.NomCom, InfoCom.NomIris,InfoCom.Population, InfoCom.ScoreGlobalCom, InfoCom.AccesInterfaceNum, InfoCom.AccesInformation, InfoCom.CompAdministrative, InfoCom.CompNumerique, CDR.NomDep, CDR.NomRegion, InfoCom.ScoreGlobalRegion FROM InfoCom, CDR, InfoCom_CDR WHERE InfoCom.CodeIris = InfoCom_CDR.CodeIris AND InfoCom_CDR.INSEE = CDR.INSEE AND CDR.NomCom LIKE :Com; and CDR.CP = :CP');
						$req->execute(array(
							'Com' => $Com,
							'CP' => $CP,
						));
						while ($donnees = $req->fetch()){

							$req2 = $bdd->prepare('INSERT INTO Records (CodePostal, NomCom, NomIris, Populations, AccesInterfaceNum, AccesInfo, CompAdmin, CompNum, ScoreCom, ScoreReg) VALUES (:CP, :NomCom, :NomIris,:Populations, :AccesInterfaceNum, :AccesInformation, :CompAdministrative, :CompNumerique, :ScoreGlobalCom, :ScoreGlobalRegion)');
							$req2->execute(array(
								'CP' => htmlspecialchars($donnees['CP']),
								'NomCom' => htmlspecialchars($donnees['NomCom']),
								'NomIris' => htmlspecialchars($donnees['NomIris']),
								'Populations' => htmlspecialchars($donnees['Population']),
								'AccesInterfaceNum' => htmlspecialchars($donnees['AccesInterfaceNum']),
								'AccesInformation' => htmlspecialchars($donnees['AccesInformation']),
								'CompAdministrative' => htmlspecialchars($donnees['CompAdministrative']),
								'CompNumerique' => htmlspecialchars($donnees['CompNumerique']),
								'ScoreGlobalCom' => htmlspecialchars($donnees['ScoreGlobalCom']),
								'ScoreGlobalRegion' => htmlspecialchars($donnees['ScoreGlobalRegion']),
							));

							echo '<tr><td>' . htmlspecialchars($donnees['CP']) . '</td><td>' . htmlspecialchars($donnees['NomCom']) . '</td><td>' . htmlspecialchars($donnees['NomIris']) . '</td><td>' . htmlspecialchars($donnees['Population']) . '</td><td>' . htmlspecialchars($donnees['AccesInterfaceNum']) . '</td><td>' . htmlspecialchars($donnees['AccesInformation']) . '</td><td>' . htmlspecialchars($donnees['CompAdministrative']) . '</td><td>' . htmlspecialchars($donnees['CompNumerique']) . '</td><td>' . htmlspecialchars($donnees['ScoreGlobalCom']) . '</td><td>' . htmlspecialchars($donnees['ScoreGlobalRegion']) . '</td></tr>';
						}
					}
					echo '</table>';
					echo '<div id="editor"></div>';
					$req->closeCursor();
					echo '<button onclick="telecharger()">Télécharger PDF</button>';
				}
			?>
			
			<footer>
				<p>
					Mentions légales : Ce site à été réalisé par l'équipe 4 du Design4Green 2020.</br>
					Aucunes données personelles n'est enregistrées lors de l'utilisation de cette application.
				</p>
			</footer>
		</div>
	</body>
</html>