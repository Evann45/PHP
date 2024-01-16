<?php
date_default_timezone_set('Europe/Paris');

try {
    $file_db = new PDO('sqlite:contacts.sqlite3');
    $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $answers = array();
    $score = 0;

    // Récupération des réponses de la base de données
    $result = $file_db->query("SELECT * FROM answers")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $answers[$row['question_id']] = $row['is_correct'];
    }

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'question_') !== false) {
            $questionId = str_replace('question_', '', $key);
            if (isset($answers[$questionId]) && $answers[$questionId] == $value) {
                $score++;
            }
        }
    }

    // Enregistrement du score dans la base de données
    $scores = $file_db->query("SELECT score FROM scores")->fetchAll(PDO::FETCH_ASSOC);
    $file_db->exec("UPDATE INTO scores (score, time) VALUES ($score+$scores, " . time() . ")");

    // Redirection vers une nouvelle page de quiz
    header("Location: resultat_quiz.php");

    // Fermeture de la connexion à la base de données
    $file_db = null;

} catch (PDOException $ex) {
    echo $ex->getMessage();
}
?>