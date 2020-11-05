<?php
try
{
    $bdd = new PDO('mysql:host=localhost;port=3307;dbname=test;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="minichat_post.php" method="post">
        <p>
            Pseudo : 
            <input type="text" name="pseudo" />
        </p>
        <p>
            Message : 
            <input type="text" name="message" />
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </form>
</body>
</html>

<?php
$req = $bdd->query('SELECT CDR.CP, CDR.NomCom, InfoCom.Population, InfoCom.ScoreGlobalCom, InfoCom.AccesInterfaceNum, InfoCom.AccesInformation, InfoCom.CompAdministrative, InfoCom.CompNumerique, InfoCom.GlobalAcces, InfoCom.GlobalCompetences, CDR.NomDep, CDR.NomRegion, InfoCom.ScoreGlobalRegion FROM InfoCom, CDR, InfoCom_CDR WHERE InfoCom.CodeIris = InfoCom_CDR.CodeIris AND InfoCom_CDR.INSEE = CDR.INSEE AND CDR.CP = 49750;');

while ($donnees = $req->fetch())
{
    echo print_r($données);
	echo '<p> <B>' . htmlspecialchars($donnees['pseudo']) . '</B> : ' . htmlspecialchars($donnees['messages']) . '</p>';
}

$req->closeCursor();
?>