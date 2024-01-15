<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quiz sur la France</title>
</head>
<body>
    <h1>Quiz sur la France</h1>
    <form action="process.php" method="post">
        <?php
        date_default_timezone_set('Europe/Paris');
        try {
            $file_db = new PDO('sqlite:contacts.sqlite3');
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
                is_correct INTEGER)");

            // Données de test pour la table questions
            $questions = array(
                array('question' => 'La capitale de la France est-elle Paris?'),
                array('question' => 'La Tour Eiffel est-elle située à Londres?'),
                // Ajoutez autant de questions que nécessaire
            );

            // Insertion des données dans la table questions
            $insertQuestion = "INSERT INTO questions (question) VALUES (:question)";
            $stmtQuestion = $file_db->prepare($insertQuestion);
            $stmtQuestion->bindParam(':question', $question);

            foreach ($questions as $q) {
                $question = $q['question'];
                $stmtQuestion->execute();
            }

            // Données de test pour la table answers
            $answers = array(
                array('question_id' => 1, 'answer' => 'Oui', 'is_correct' => 1),
                array('question_id' => 1, 'answer' => 'Non', 'is_correct' => 0),
                array('question_id' => 2, 'answer' => 'Oui', 'is_correct' => 1),
                array('question_id' => 2, 'answer' => 'Non', 'is_correct' => 0),
                // Ajoutez autant de réponses que nécessaire
            );

            // Insertion des données dans la table answers
            $insertAnswer = "INSERT INTO answers (question_id, answer, is_correct) VALUES (:question_id, :answer, :is_correct)";
            $stmtAnswer = $file_db->prepare($insertAnswer);
            $stmtAnswer->bindParam(':question_id', $question_id);
            $stmtAnswer->bindParam(':answer', $answer);
            $stmtAnswer->bindParam(':is_correct', $is_correct);

            foreach ($answers as $a) {
                $question_id = $a['question_id'];
                $answer = $a['answer'];
                $is_correct = $a['is_correct'];
                $stmtAnswer->execute();
            }

            // Récupération des questions de la base de données
            $questions = $file_db->query("SELECT * FROM questions")->fetchAll(PDO::FETCH_ASSOC);

            foreach ($questions as $question) {
                echo '<p>' . $question['question'] . '</p>';
                echo '<input type="radio" name="question_' . $question['id'] . '" value="1"> Oui ';
                echo '<input type="radio" name="question_' . $question['id'] . '" value="0"> Non <br>';
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