<?php
session_start(); // Assurez-vous de démarrer la session au début du fichier

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/correction.css">
    <title>Correction du Quiz</title>
</head>
<body>
    <h1>Correction du Quiz</h1>

    <?php
    date_default_timezone_set('Europe/Paris');
    require 'database.php';
    try {

        // Récupération des questions de la base de données
        $questions = $file_db->query("SELECT * FROM questions")->fetchAll(PDO::FETCH_ASSOC);

        // Affichage des questions
        foreach ($questions as $question) {
            echo '<p>' . $question['question'] . '</p>';
            
            // Récupération de la réponse correcte de la base de données
            $stmt = $file_db->prepare("SELECT * FROM answers WHERE question_id = :questionId");

            $stmt->bindParam(':questionId', $question['id'], PDO::PARAM_INT);
            $stmt->execute();
            $answer = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt2 = $file_db->prepare("SELECT * FROM answers WHERE question_id = :questionId AND is_correct = 1");
            $stmt2->bindParam(':questionId', $question['id'], PDO::PARAM_INT);
            $stmt2->execute();
            $correctAnswer = $stmt2->fetch(PDO::FETCH_ASSOC);


            // Vérifie si la réponse de l'utilisateur est correcte
            $isUserAnswerCorrect = isset($_SESSION['question_' . $question['id']]) && $_SESSION['question_' . $question['id']] == $answer['is_correct'];

            echo '<ul>';
            echo '<li class="' . ($isUserAnswerCorrect ? 'correct' : 'incorrect') . '">';
            echo 'Votre réponse : ' . ($isUserAnswerCorrect ? 'Correcte' : 'Incorrecte');
            echo '</li>';
            echo '<li>';
            echo 'Réponse correcte : ' . $correctAnswer['answer'];
            echo '</li>';
            echo '</ul>';
        }

        // Bouton pour consulter tous les scores
        echo '<a href="consulter_scores.php"><button>Consulter tous les scores</button></a>';

        // Fermeture de la connexion à la base de données
        $file_db = null;

    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    ?>
</body>
</html>
