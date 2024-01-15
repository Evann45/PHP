<?php
date_default_timezone_set('Europe/Paris');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $file_db = new PDO('sqlite:contacts.sqlite3');
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        // Création de la table participants si elle n'existe pas
        $file_db->exec("CREATE TABLE IF NOT EXISTS participants (
            id INTEGER PRIMARY KEY,
            nom TEXT,
            prenom TEXT,
            time INTEGER)");

        // Enregistrement du nom, prénom et date dans la table participants
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $time = time();

        $insertParticipant = "INSERT INTO participants (nom, prenom, time) VALUES (:nom, :prenom, :time)";
        $stmtParticipant = $file_db->prepare($insertParticipant);

        $stmtParticipant->bindParam(':nom', $nom);
        $stmtParticipant->bindParam(':prenom', $prenom);
        $stmtParticipant->bindParam(':time', $time);

        $stmtParticipant->execute();

        // Redirection vers la page du quiz
        header("Location: index.php");

        // Fermeture de la connexion à la base de données
        $file_db = null;

    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}
?>