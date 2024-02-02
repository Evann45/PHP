<?php
session_start();

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
            if (isset($answers[$questionId]) && $answers[$questionId] == $value) {
            } else {
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

    // Enregistrement du score dans la session
    $_SESSION['score'] = $score;

    // Redirection vers la prochaine page du quiz
    header('Location: quiz_japon.php');
    exit();

    // Fermeture de la connexion à la base de données
    $file_db = null;

} catch (PDOException $ex) {
    echo $ex->getMessage();
}
?>
