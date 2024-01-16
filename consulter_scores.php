<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Consulter les Scores</title>
</head>
<body>
    <h1>Consulter les Scores</h1>

    <?php
    date_default_timezone_set('Europe/Paris');

    try {
        $file_db = new PDO('sqlite:contacts.sqlite3');
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        // Récupération de tous les scores de la base de données
        $scores = $file_db->query("SELECT * FROM scores ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

        if ($scores) {
            echo '<ul>';
            foreach ($scores as $score) {
                $person = $file_db->query("SELECT * FROM participants NATURAL JOIN scores WHERE id = ". $score['participant_id'])->fetch(PDO::FETCH_ASSOC);
                echo '<li>'. $person['nom'] .' ' . $person['prenom'] .' - Score : ' . $score['score'] . ' points - Date du quiz : ' . date('Y-m-d H:i:s', $score['time']) . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>Aucun score disponible.</p>';
        }

        // Fermeture de la connexion à la base de données
        $file_db = null;

    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    ?>

</body>
</html>