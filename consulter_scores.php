<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/scores.css">
    <script>
        function clearFilters() {
            // Réinitialise les valeurs des champs de recherche
            document.getElementById('searchByName').value = '';
            document.getElementById('searchByScore').value = '';

            // Cache le bouton "Supprimer Filtre"
            document.getElementById('clearFilterButton').style.display = 'none';

            // Redirige vers la page sans les paramètres de recherche
            window.location.href = 'consulter_scores.php';
        }
    </script>

    <title>Consulter les Scores</title>
</head>
<body>
    <h1>Consulter les Scores</h1>
    <section>
        <div class="search-form">
            <!-- Formulaire de recherche par nom -->
            <form method="get">
                <label for="searchByName">Rechercher par nom :</label>
                <input type="text" id="searchByName" name="searchByName">
                <button type="submit" name="submitNameSearch">Rechercher</button>
            </form>

            <!-- Formulaire de recherche par score -->
            <form method="get" >
                <label for="searchByScore">Rechercher par score :</label>
                <input type="number" id="searchByScore" name="searchByScore" min="0">
                <button type="submit" name="submitScoreSearch">Rechercher</button>
            </form>
            <button id="clearFilterButton" onclick="clearFilters()">Supprimer Filtre</button>
        </div>
    </section>

    <?php
    require 'database.php';
    try {
        // Récupération de tous les scores de la base de données avec les informations des participants
        $query = "SELECT scores.*, participants.nom, participants.prenom 
            FROM scores 
            INNER JOIN participants ON scores.participant_id = participants.idP";

        // Filtrage par nom
        $searchByName = isset($_GET['searchByName']) ? $_GET['searchByName'] : '';
        if (!empty($searchByName)) {
            $query .= " WHERE participants.nom LIKE :searchByName ";
        }

        // Filtrage par score
        $searchByScore = isset($_GET['searchByScore']) ? $_GET['searchByScore'] : '';
        if (!empty($searchByScore)) {
            $query .= " AND scores.score = :searchByScore ";
        }

        // Trier les résultats par ID de score de manière décroissante
        $query .= " ORDER BY scores.id DESC";

        // Préparation de la requête
        $stmt = $file_db->prepare($query);

        // Liaison des paramètres pour le filtre par nom
        if (!empty($searchByName)) {
            $stmt->bindValue(':searchByName', "%$searchByName%", PDO::PARAM_STR);
        }

        // Liaison des paramètres pour le filtre par score
        if (!empty($searchByScore)) {
            $stmt->bindValue(':searchByScore', $searchByScore, PDO::PARAM_INT);
        }

        // Exécution de la requête
        $result = $stmt->execute();

        if (!$result) {
            echo "Erreur SQL : " . print_r($file_db->errorInfo(), true);
        } else {
            $scores = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <div>
        <button class="button" onclick="window.location.href='index.php'">Retour à l'accueil</button>
    </div>
</body>
</html>
