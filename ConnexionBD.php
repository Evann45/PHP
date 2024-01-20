<?php

namespace BD;

use PDO;
use PDOException;

class ConnexionBD {

    private static $db = null;
    public function __construct() {
        date_default_timezone_set('Europe/Paris');
        try {
            if (self::$db === null) {
                $questions = $this->create_questions();

                self::$db = $this->init_DB();
                $this->create_tables();
                $this->make_insert_quizz();
                $this->make_insert_questions($questions);
                $this->make_insert_reponse($questions);
                $this->make_insert_choix($questions);
            }

        } catch (PDOException $e) {}
    }

    public static function obtenir_connexion() {
        if (self::$db === null) {
            try {
                new ConnexionBD();
            } catch (PDOException $e) {
                die('Erreur de connexion à la base de données : ' . $e->getMessage());
            }
        }
        return self::$db;
    }

    function init_DB() {
        if (self::$db == null) {
            $cheminFichierSQLite = __DIR__ . '/../quizz.sqlite3';
            self::$db = new PDO('sqlite:' . $cheminFichierSQLite);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$db;
    }

    function create_tables() {
        self::$db->exec("CREATE TABLE IF NOT EXISTS Quizz (
            id_quizz INTEGER PRIMARY KEY AUTOINCREMENT,
            name_quizz TEXT
        )");

        self::$db->exec("CREATE TABLE IF NOT EXISTS Question (
            ID_question INTEGER PRIMARY KEY,
            Nom_question TEXT,
            Type_question TEXT,
            Texte_question TEXT,
            Points_gagnes INTEGER,
            ID_quizz INTEGER,
            FOREIGN KEY (ID_quizz) REFERENCES Quizz(ID_quizz)
        )");

        self::$db->exec("CREATE TABLE IF NOT EXISTS Reponse (
            ID_reponse INTEGER PRIMARY KEY AUTOINCREMENT,
            Texte_reponse TEXT,
            Est_correcte BOOLEAN,
            ID_question INTEGER,
            FOREIGN KEY (ID_question) REFERENCES Question(ID_question)
        )");

        self::$db->exec("CREATE TABLE IF NOT EXISTS Choix (
            ID_choix INTEGER PRIMARY KEY AUTOINCREMENT,
            Texte_choix TEXT,
            Value_choix TEXT,
            ID_question INTEGER,
            FOREIGN KEY (ID_question) REFERENCES Question(ID_question)
        );");
    }

    function make_insert_quizz() {
        $checkQuizz = "SELECT COUNT(*) FROM Quizz WHERE name_quizz = 'Le quizz délirant !'";
        $stmtCheck = self::$db->query($checkQuizz);
        $quizzCount = $stmtCheck->fetchColumn();

        if ($quizzCount == 0) {
            $insertQuizz = "INSERT INTO Quizz (name_quizz) VALUES ('Le quizz délirant !')";
            $stmt = self::$db->prepare($insertQuizz);
            $stmt->execute();
        }
    }

    function make_insert_questions($questions) {
        $id_question = null;
        $name = null;
        $type = null;
        $text = null;
        $points = null;

        $insertQuestions = "INSERT INTO Question (ID_question, Nom_question, Type_question, Texte_question, Points_gagnes, ID_quizz) VALUES (:id_question, :name, :type, :text, :points, 1)";

        $stmt = self::$db->prepare($insertQuestions);
        $stmt->bindParam(':id_question', $id_question);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':points', $points);

        foreach ($questions as $question) {
            $checkQuestion = "SELECT COUNT(*) FROM Question WHERE ID_question = :id_question";
            $stmtCheck = self::$db->prepare($checkQuestion);
            $stmtCheck->bindParam(':id_question', $question['id']);
            $questionCount = $stmtCheck->fetchColumn();

            if ($questionCount == 0) {
                $id_question = $question['id'];
                $name = $question['name'];
                $type = $question['type'];
                $text = $question['text'];
                $points = $question['score'];
                $stmt->execute();
            }
        }
    }

    function make_insert_reponse($questions) {
        $answer = null;
        $id_question = null;
        $insertReponse = "INSERT INTO Reponse (Texte_reponse, Est_correcte, ID_question) VALUES (:text_res, :est_correcte, :id_question)";

        $stmt = self::$db->prepare($insertReponse);
        $stmt->bindParam(':text_res', $answer);
        $stmt->bindParam(':est_correcte', $est_correcte);
        $stmt->bindParam(':id_question', $id_question);

        foreach ($questions as $question) {
            if (is_array($question['answer'])) {
                foreach ($question['answer'] as $current_answer) {
                    $checkReponse = "SELECT COUNT(*) FROM Reponse WHERE Texte_reponse = :text_res AND ID_question = :id_question";
                    $stmtCheck = self::$db->prepare($checkReponse);
                    $stmtCheck->bindParam(':text_res', $current_answer);
                    $stmtCheck->bindParam(':id_question', $question['id']);
                    $reponseCount = $stmtCheck->fetchColumn();
                    if ($reponseCount == 0) {
                        $answer = $current_answer;
                        $id_question = $question['id'];
                        $stmt->execute();
                    }
                }
            } else {
                $checkReponse = "SELECT COUNT(*) FROM Reponse WHERE Texte_reponse = :text_res AND ID_question = :id_question";
                $stmtCheck = self::$db->prepare($checkReponse);
                $stmtCheck->bindParam(':text_res', $question['answer']);
                $stmtCheck->bindParam(':id_question', $question['id']);
                $reponseCount = $stmtCheck->fetchColumn();
                if ($reponseCount == 0) {
                    $answer = $question['answer'];
                    $id_question = $question['id'];
                    $stmt->execute();
                }
            }
        }
    }

    function make_insert_choix($questions) {
        $texte_choix = null;
        $value_choix = null;
        $id_question = null;

        $insertReponse = "INSERT INTO Choix (Texte_choix, Value_choix, ID_question) VALUES (:texte_choix, :value_choix, :id_question)";

        $stmt = self::$db->prepare($insertReponse);
        $stmt->bindParam(':texte_choix', $texte_choix);
        $stmt->bindParam(':value_choix', $value_choix);
        $stmt->bindParam(':id_question', $id_question);

        foreach ($questions as $question) {
            if (isset($question['choices'])) {
                foreach ($question['choices'] as $current_choice) {
                    $checkChoix = "SELECT COUNT(*) FROM Choix WHERE ID_question = :id_question AND Texte_choix = :texte_choix";
                    $stmtCheck = self::$db->prepare($checkChoix);
                    $stmtCheck->bindParam(':id_question', $question['id']);
                    $stmtCheck->bindParam(':texte_choix', $current_choice['text']);
                    $choixCount = $stmtCheck->fetchColumn();
                    if ($choixCount == 0) {
                        $texte_choix = $current_choice['text'];
                        $value_choix = $current_choice['value'];
                        $id_question = $question['id'];
                        $stmt->execute();
                    }
                }
            }
        }
    }

    function create_questions() {
        $questions = [
            array(
                "id" => 1,
                "name" => "capitale",
                "type" => "text",
                "text" => "Quelle est la capitale de la France ? ",
                "answer" => "Paris",
                "score" => 1
            ),
            array(
                "id" => 2,
                "name" => "animaux",
                "type" => "radio",
                "text" => "Quel est le plus grand mammifère terrestre ? ",
                "choices" => [
                    array(
                        "text" => "Éléphant",
                        "value" => "elephant"),
                    array(
                        "text" => "Baleine bleue",
                        "value" => "baleine"),
                    array(
                        "text" => "Girafe",
                        "value" => "girafe"),
                ],
                "answer" => "baleine",
                "score" => 2
            ),
            array(
                "id" => 3,
                "name" => "couleurs",
                "type" => "checkbox",
                "text" => "Sélectionnez les couleurs primaires : ",
                "choices" => [
                    array(
                        "text" => "Bleu",
                        "value" => "bleu"
                    ),
                    array(
                        "text" => "Vert",
                        "value" => "vert"
                    ),
                    array(
                        "text" => "Rouge",
                        "value" => "rouge"
                    ),
                    array(
                        "text" => "Jaune",
                        "value" => "jaune"
                    ),
                    array(
                        "text" => "Rose",
                        "value" => "rose"
                    )
                ],
                "answer" => ["bleu", "vert", "rouge"],
                "score" => 3
            ),
            array(
                "id" => 4,
                "name" => "villes",
                "type" => "text",
                "text" => "Quelle est la deuxième plus grande ville des États-Unis ? ",
                "answer" => "Los Angeles",
                "score" => 4
            ),
            array(
                "id" => 5,
                "name" => "planètes",
                "type" => "text",
                "text" => "Quelle est la quatrième planète à partir du soleil ? ",
                "answer" => "Mars",
                "score" => 4
            ),
            array(
                "id" => 6,
                "name" => "inventions",
                "type" => "radio",
                "text" => "Qui a inventé la première ampoule électrique ? ",
                "choices" => [
                    array(
                        "text" => "Thomas Edison",
                        "value" => "edison"),
                    array(
                        "text" => "Nikola Tesla",
                        "value" => "tesla"),
                    array(
                        "text" => "Alexander Graham Bell",
                        "value" => "bell"),
                ],
                "answer" => "edison",
                "score" => 2
            ),
        ];
        return $questions;
    }
}

?>