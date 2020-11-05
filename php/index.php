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
$req = $bdd->query('SELECT id, pseudo, messages FROM chat ORDER BY id DESC LIMIT 10');

while ($donnees = $req->fetch())
{
	echo '<p> <B>' . htmlspecialchars($donnees['pseudo']) . '</B> : ' . htmlspecialchars($donnees['messages']) . '</p>';
}

//http://localhost/tests/TP%20minichat/minichat.php



$req->closeCursor();
?>