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
        score INTEGER,
        time INTEGER)");

    echo "Tables créées avec succès.";

    // Fermeture de la connexion à la base de données
    $file_db = null;

} catch (PDOException $ex) {
    echo $ex->getMessage();
}
?>
