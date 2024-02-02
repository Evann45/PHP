<?php
session_start();

date_default_timezone_set('Europe/Paris');
require 'database.php';
try {
    $answers = array();

    // Récupération des réponses de la base de données
    $result = $file_db->query("SELECT * FROM answers")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $answers[$row['question_id']] = $row['is_correct'];
    }

    $score = 0;

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'question_') !== false) {
            $questionId = str_replace('question_', '', $key);
            if (isset($answers[$questionId]) && $answers[$questionId] == $value) {}
            else{
                $score++;
            }
        }
    }

    // Enregistrement des réponses de l'utilisateur dans la session
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'question_') !== false) {
            $_SESSION[$key] = $value;
        }
    }


    // Ajouter le score précédent
    $previousScore = isset($_SESSION['score']) ? $_SESSION['score'] : 0;
    $totalScore = $score + $previousScore;

    // Récupérer l'id du participant depuis la session
    $participant_id = $_SESSION['participant_id'];

    // Mettre à jour le score dans la base de données
    $file_db->exec("UPDATE scores SET score = $totalScore, time = " . time() . " WHERE participant_id = $participant_id");

    // Redirection vers la page de résultat
    header('Location: resultat_quiz.php');
    exit();

    // Fermeture de la connexion à la base de données
    $file_db = null;

} catch (PDOException $ex) {
    echo $ex->getMessage();
}
?>
