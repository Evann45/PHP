<?php
session_start();

date_default_timezone_set('Europe/Paris');

try {
    $file_db = new PDO('sqlite:contacts.sqlite3');
    $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

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
            if (isset($answers[$questionId]) && $answers[$questionId] == $value && $value == 1) {}
            else{
                $score++;
            }
        }
    }

    // Enregistrement du score dans la session
    $_SESSION['score'] = $score;

    // Redirection vers la prochaine page du quiz
    header('Location: nouvelle_page_japon.php');
    exit();

    // Fermeture de la connexion à la base de données
    $file_db = null;

} catch (PDOException $ex) {
    echo $ex->getMessage();
}
?>
