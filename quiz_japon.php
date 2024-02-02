<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/quiz.css">
    <title>Quiz Japon</title>
</head>
<body>
    <h1>Quiz sur le Japon</h1>
    
    <form action="process_japon.php" method="post">
        <?php
        require 'database.php';
        try {

            // Récupération des questions sur le Japon de la base de données
            $questions = $file_db->query("SELECT * FROM questions WHERE id BETWEEN 4 AND 6")->fetchAll(PDO::FETCH_ASSOC);

            foreach ($questions as $question) {
                echo '<p>' . $question['question'] . '</p>';
                echo '<label><input type="radio" name="question_' . $question['id'] . '" value="1"> Oui </label>';
                echo '<label><input type="radio" name="question_' . $question['id'] . '" value="0"> Non </label><br>';
            }

            // Fermeture de la connexion à la base de données
            $file_db = null;

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        ?>
        <input type="submit" value="Soumettre">
    </form>
</body>
</html>
