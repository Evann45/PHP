<?php
date_default_timezone_set('Europe/Paris');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $file_db = new PDO('sqlite:contacts.sqlite3');
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);


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

        // Récupération de l'id du participant que nous venons d'insérer
        $participant_id = $file_db->lastInsertId();

        // Insertion d'une nouvelle entrée dans la table scores avec l'id du participant
        $insertScore = "INSERT INTO scores (participant_id, score, time) VALUES (:participant_id, 0, :time)";
        $stmtScore = $file_db->prepare($insertScore);

        $stmtScore->bindParam(':participant_id', $participant_id);
        $stmtScore->bindParam(':time', $time);

        $stmtScore->execute();

        // Redirection vers la page du quiz
        header("Location: index.php");

        // Fermeture de la connexion à la base de données
        $file_db = null;

    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}
?>