<?php
date_default_timezone_set('Europe/Paris');

try {
    $file_db = new PDO('sqlite:contacts.sqlite3'); // Nomme le fichier db sqlite
    $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    // Création de la table questions si elle n'existe pas
    $file_db->exec("CREATE TABLE IF NOT EXISTS questions (
        id INTEGER PRIMARY KEY,
        question TEXT)");

    // Création de la table answers si elle n'existe pas
    $file_db->exec("CREATE TABLE IF NOT EXISTS answers (
        id INTEGER PRIMARY KEY,
        question_id INTEGER,
        answer TEXT,
        is_correct INTEGER,
        FOREIGN KEY (question_id) REFERENCES questions(id))");

    // Création de la table scores si elle n'existe pas
    $file_db->exec("CREATE TABLE IF NOT EXISTS scores (
        id INTEGER PRIMARY KEY,
        participant_id INTEGER,
        score INTEGER,
        time INTEGER,
        FOREIGN KEY (participant_id) REFERENCES participants(idP))");

    // Création de la table participants si elle n'existe pas
    $file_db->exec("CREATE TABLE IF NOT EXISTS participants (
        idP INTEGER PRIMARY KEY,
        nom TEXT,
        prenom TEXT,
        time INTEGER)");

    echo "Tables créées avec succès.";

    // Données de test pour la table questions
    $questions = array(
        array('question' => 'La capitale de la France est-elle Paris?'),
        array('question' => 'La Tour Eiffel est-elle située à Londres?'),
        array('question' => 'Kevin est le président de la France?'),
        array('question' => 'Tokyo est la capitale du Japon?'),
        array('question' => 'le ramens est un plat japonais?'),
        array('question' => 'Le Japon est une île?'),
    );

    // Insertion des données dans la table questions
    $insertQuestion = "INSERT INTO questions (question) VALUES (:question)";
    $stmtQuestion = $file_db->prepare($insertQuestion);
    $stmtQuestion->bindParam(':question', $question);

    foreach ($questions as $q) {
        $question = $q['question'];
        $stmtQuestion->execute();
    }

    // Données de test pour la table answers
    $answers = array(
        array('question_id' => 1, 'answer' => 'Oui', 'is_correct' => 1),
        array('question_id' => 1, 'answer' => 'Non', 'is_correct' => 0),
        array('question_id' => 2, 'answer' => 'Oui', 'is_correct' => 0),
        array('question_id' => 2, 'answer' => 'Non', 'is_correct' => 1),
        array('question_id' => 3, 'answer' => 'Oui', 'is_correct' => 0),
        array('question_id' => 3, 'answer' => 'Non', 'is_correct' => 1),
        // Question sur le Japon
        array('question_id' => 4, 'answer' => 'Oui', 'is_correct' => 1),
        array('question_id' => 4, 'answer' => 'Non', 'is_correct' => 0),
        array('question_id' => 5, 'answer' => 'Oui', 'is_correct' => 1),
        array('question_id' => 5, 'answer' => 'Non', 'is_correct' => 0),
        array('question_id' => 6, 'answer' => 'Oui', 'is_correct' => 1),
        array('question_id' => 6, 'answer' => 'Non', 'is_correct' => 0),
    );

    // Insertion des données dans la table answers
    $insertAnswer = "INSERT INTO answers (question_id, answer, is_correct) VALUES (:question_id, :answer, :is_correct)";
    $stmtAnswer = $file_db->prepare($insertAnswer);
    $stmtAnswer->bindParam(':question_id', $question_id);
    $stmtAnswer->bindParam(':answer', $answer);
    $stmtAnswer->bindParam(':is_correct', $is_correct);

    foreach ($answers as $a) {
        $question_id = $a['question_id'];
        $answer = $a['answer'];
        $is_correct = $a['is_correct'];
        $stmtAnswer->execute();
    }

    // Fermeture de la connexion à la base de données
    $file_db = null;

} catch (PDOException $ex) {
    echo $ex->getMessage();
}
?>
