<?php
// Effectuer ici la requête qui insère le message
try
{
    $bdd = new PDO('mysql:host=localhost;port=3307;dbname=test;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

if (isset($_POST['pseudo']) AND isset($_POST['message'])) {
    $pseudo = $_POST['pseudo'];
    $message = $_POST['message'];

    $req = $bdd->prepare('INSERT INTO chat(pseudo, messages) VALUES(:pseudo, :messages)');
    $req->execute(array(
        'pseudo' => $pseudo,
        'messages' => $message,
));
}

// Puis rediriger vers minichat.php comme ceci :
header('Location: minichat.php');
?>