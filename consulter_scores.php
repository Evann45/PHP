<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/scores.css">
    <title>Consulter les Scores</title>
</head>
<body>
    <h1>Consulter les Scores</h1>

    <?php
    date_default_timezone_set('Europe/Paris');

    try {
        $file_db = new PDO('sqlite:contacts.sqlite3');
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        // Récupération de tous les scores de la base de données avec les informations des participants
        $query = "SELECT scores.*, participants.nom, participants.prenom 
                  FROM scores 
                  INNER JOIN participants ON scores.participant_id = participants.idP 
                  ORDER BY scores.id DESC";

        $scores = $file_db->query($query);

        if (!$scores) {
            echo "Erreur SQL : " . print_r($file_db->errorInfo(), true);
        } else {
            $scores = $scores->fetchAll(PDO::FETCH_ASSOC);

            if ($scores) {
                echo '<ul>';
                foreach ($scores as $score) {
                    echo '<li>'. $score['nom'] .' ' . $score['prenom'] .' - Score : ' . $score['score'] . ' points - Date du quiz : ' . date('Y-m-d H:i:s', $score['time']) . '</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>Aucun score disponible.</p>';
            }
        }

        // Fermeture de la connexion à la base de données
        $file_db = null;

    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    ?>

    <button onclick="window.location.href='accueil.php'">Retour à l'accueil</button>

</body>
</html>
