<?php
date_default_timezone_set('Europe/Paris');

try {
    $file_db = new PDO('sqlite:contacts.sqlite3');
    $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    // Création de la table scores si elle n'existe pas
    $file_db->exec("CREATE TABLE IF NOT EXISTS scores (
        id INTEGER PRIMARY KEY,
        score INTEGER,
        time INTEGER)");

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
    $file_db->exec("INSERT INTO scores (score, time) VALUES ($score, " . time() . ")");

    // Redirection vers une nouvelle page de quiz
    header("Location: resultat_quiz.php");

    // Fermeture de la connexion à la base de données
    $file_db = null;

} catch (PDOException $ex) {
    echo $ex->getMessage();
}
?>