<?php
// Démarrer la session
session_start();

// Initialiser le score si ce n'est pas déjà fait
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}

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

        // Enregistrement du score dans la session
        $_SESSION['score'] = 0;  // Réinitialise le score à 0
        $_SESSION['participant_id'] = $participant_id;  // Stocke l'ID du participant dans la session

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
