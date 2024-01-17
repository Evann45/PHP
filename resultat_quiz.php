<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/resultat.css">
    <title>Résultat du Quiz</title>
</head>
<body>
    <h1>Résultat du Quiz</h1>

    <?php
    date_default_timezone_set('Europe/Paris');
    require 'database.php';
    try {

        // Récupération du dernier score enregistré dans la base de données
        $result = $file_db->query("SELECT * FROM scores ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo '<p>Votre score est de ' . $result['score'] . ' points.</p>';
            echo '<p>Date du quiz : ' . date('Y-m-d H:i:s', $result['time']) . '</p>';

            // Bouton pour consulter tous les scores
            echo '<a href="consulter_scores.php"><button>Consulter tous les scores</button></a>';

            // Bouton pour voir la correction
            echo '<a href="correction.php"><button>Voir la correction</button></a>';
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
