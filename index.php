<?php
// Démarrer la session
session_start();

// Réinitialiser la variable de session du score
$_SESSION['score'] = 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/accueil.css">
    <title>Accueil</title>
</head>
<body>
    <h1>Bienvenue au Quiz</h1>

    <form action="process_index.php" method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required><br>

        <input type="submit" value="Participer au Quiz">
    </form>
</body>
</html>
