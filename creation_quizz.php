<?php

$redirection = isset($_POST['redirection']) ? $_POST['redirection'] : 'false';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $redirection === 'false') {
    $nomQuizz = isset($_POST['nom_quizz']) ? $_POST['nom_quizz'] : '';
    $nbQuestion = isset($_POST['nb_question']) ? $_POST['nb_question'] : '';
    if (!empty($nomQuizz) && !empty($nbQuestion)) {
        header('Location: creation_quizz.php?redirection=true&nb_question=' . $nbQuestion . '&nom_quizz=' . $nomQuizz);
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de votre quizz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    if ($redirection === 'false') {
        echo "<form method='post' action='creation_quizz.php'>";
        echo "<input type='hidden' name='redirection' value='true'>";
        echo "<h3>Nom du quizz</h3>";
        echo "<input type='text' style='width: 50%;' name='nom_quizz' placeholder='Insérer un nom de quizz'>";
        echo "<h3>Insérer le nombre de question</h3>";
        echo "<input type='text' style='width: 50%;' name='nb_question' placeholder='Combien de questions voulez-vous créer ?'>";
        echo "<br>";
        echo "<br>";
        echo "<input type='submit' id='refresh' value='Créer vos questions'>";
        echo "</form>";
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $redirection === 'true') {
        $nbQuestion = isset($_POST['nb_question']) ? $_POST['nb_question'] : 0;
        $nomQuizz = isset($_POST['nom_quizz']) ? $_POST['nom_quizz'] : '';

        echo "<form method='post' action='bd.php?nb_question=$nbQuestion&nom_quizz=$nomQuizz'>";
        for ($i = 0; $i < $nbQuestion; $i++) {
            echo "<p>Question n°" . ($i + 1) . "</p>";
            echo "<label for='nom_question_$i'>Nom de la question :</label>";
            echo "<input type='text' style='width: 50%;' name='nom_question_$i' id='nom_question_$i' placeholder='Entrez le nom de la question'>";
            echo "<label for='rep_question_$i'>Réponse de la question :</label>";
            echo "<input type='text' style='width: 50%;' name='rep_question_$i' id='rep_question_$i' placeholder='Entrez le nom de la question'>";
            echo "<br>";
        }
        echo "<br>";
        echo "<br>";
        echo "<input type='submit' id='refresh' value='Publier votre quizz'>";
        echo "</form>";
    }
    ?>
</body>
</html>