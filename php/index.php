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
		<link rel="icon" href="favicon.png" />

		<script type="text/javascript" src="script.js"></script>

		<style>
			body{
				display: flex;
				flex-direction: column;
			}
			.titre{
				text-align: center;
				background-color: green;
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
		</style>
	</head>
	
	<body>
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
			<form>
				<p>Chercher une commune par : </p>
				<label for="CP">Code Postal</label>
				<input type="text" name="CP" id="CP">
				<br>
				<label for="NomCommune">Nom de commune</label>
				<select name="NomCommune" id="NomCommune">
					<option value="1">Choisir une commune</option>
				</select>
				<br>
				<button onclick="/script.js/nodejs()">Rechercher</button>
			</form>
		</div>

		<?php
            $req = $bdd->query('SELECT CDR.CP, CDR.NomCom, InfoCom.Population, InfoCom.ScoreGlobalCom, InfoCom.AccesInterfaceNum, InfoCom.AccesInformation, InfoCom.CompAdministrative, InfoCom.CompNumerique, CDR.NomDep, CDR.NomRegion, InfoCom.ScoreGlobalRegion FROM InfoCom, CDR, InfoCom_CDR WHERE InfoCom.CodeIris = InfoCom_CDR.CodeIris AND InfoCom_CDR.INSEE = CDR.INSEE AND CDR.CP = 71220;') or die(print_r($bdd->errorInfo()));

            echo '<table>
            <tr><th rowspan="2">Code Postal</th><th colspan="2">Commune</th><th colspan="2">Accès</th><th colspan="2">Compétences</th><th rowspan="2">Score Global Commune</th><th rowspan="2">Score Global Région</th></tr>
            <tr><td>Nom</td><td>Population</td><td>Accès aux interfaces numériques</td><td>Accès à l\'information</td><td>Compétences administratives</td><td>Compétences numériques/scolaires</td></tr>';

            while ($donnees = $req->fetch()){

                echo '<tr><td>' . htmlspecialchars($donnees['CP']) . '</td><td>' . htmlspecialchars($donnees['NomCom']) . '</td><td>' . htmlspecialchars($donnees['Population']) . '</td><td>' . htmlspecialchars($donnees['AccesInterfaceNum']) . '</td><td>' . htmlspecialchars($donnees['AccesInformation']) . '</td><td>' . htmlspecialchars($donnees['CompAdministrative']) . '</td><td>' . htmlspecialchars($donnees['CompNumerique']) . '</td><td>' . htmlspecialchars($donnees['ScoreGlobalCom']) . '</td><td>' . htmlspecialchars($donnees['ScoreGlobalRegion']) . '</td></tr>';
            }

            echo '</table>';

            $req->closeCursor();
        ?>
		<p>La région est ...</p>
	</body>
</html>