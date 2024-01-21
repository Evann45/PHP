<?php
$nbQuestions = isset($_GET['nb_question']) ? (int)$_GET['nb_question'] : 0;
$nomQuizz = isset($_GET['nom_quizz']) ? $_GET['nom_quizz'] : '';

require_once __DIR__ . '/ConnexionBD.php';
require_once __DIR__ . '/RequeteBDD.php';

use BD\RequeteBDD;
use BD\ConnexionBD;

$connexionBD = new ConnexionBD();
$requeteBDD = new RequeteBDD("Quizz");

$idQuizz = $requeteBDD->inserer_quizz($connexionBD::obtenir_connexion(), $nomQuizz);
$idQuizz = $idQuizz->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < $nbQuestions; $i++) {
    $nomQuestion = isset($_POST["nom_question_$i"]) ? $_POST["nom_question_$i"] : '';
    $repQuestion = isset($_POST["rep_question_$i"]) ? $_POST["rep_question_$i"] : '';
    $idQuestion = $requeteBDD->insererQuestion($connexionBD::obtenir_connexion(), $nomQuestion, $idQuizz[0]['MAX(id_quizz)']);
    $idRep = $requeteBDD->insererReponse($connexionBD::obtenir_connexion(), $repQuestion, $idQuestion);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Creez votre quizz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Merci d'avoir creez votre quizz !</h1>
    <form name="x" action="index.php" method="post">
        <input type="submit" value="Revenir à la page d'accueil">
    </form>
</body>
</html>
