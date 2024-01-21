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
                $questions = $this->creer_questions();

                self::$db = $this->initialiser_DB();
                $this->creer_tables();
                $this->inserer_quizz();
                $this->inserer_questions($questions);
                $this->inserer_reponse($questions);
                $this->inserer_choix($questions);
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

    function initialiser_DB() {
        if (self::$db == null) {
            $cheminFichierSQLite = __DIR__ . '/quizz.sqlite3';
            self::$db = new PDO('sqlite:' . $cheminFichierSQLite);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$db;
    }

    function creer_tables() {
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

    function inserer_quizz() {
        $verifierQuizz = "SELECT COUNT(*) FROM Quizz WHERE name_quizz = 'Le quizz d Evann et Kévin !'";
        $stmtVerif = self::$db->query($verifierQuizz);
        $quizzCompte = $stmtVerif->fetchColumn();

        if ($quizzCompte == 0) {
            $insererQuizz = "INSERT INTO Quizz (name_quizz) VALUES ('Le quizz d Evann et Kévin !')";
            $stmt = self::$db->prepare($insererQuizz);
            $stmt->execute();
        }
    }

    function inserer_questions($questions) {
        $id_question = null;
        $nom = null;
        $type = null;
        $texte = null;
        $points = null;

        $insererQuestions = "INSERT INTO Question (ID_question, Nom_question, Type_question, Texte_question, Points_gagnes, ID_quizz) VALUES (:id_question, :nom, :type, :texte, :points, 1)";

        $stmt = self::$db->prepare($insererQuestions);
        $stmt->bindParam(':id_question', $id_question);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':texte', $texte);
        $stmt->bindParam(':points', $points);

        foreach ($questions as $question) {
            $verifierQuestion = "SELECT COUNT(*) FROM Question WHERE ID_question = :id_question";
            $stmtVerif = self::$db->prepare($verifierQuestion);
            $stmtVerif->bindParam(':id_question', $question['id']);
            $questionCompte = $stmtVerif->fetchColumn();

            if ($questionCompte == 0) {
                $id_question = $question['id'];
                $nom = $question['name'];
                $type = $question['type'];
                $texte = $question['text'];
                $points = $question['score'];
                $stmt->execute();
            }
        }
    }

    function inserer_reponse($questions) {
        $reponse = null;
        $id_question = null;
        $insererReponse = "INSERT INTO Reponse (Texte_reponse, Est_correcte, ID_question) VALUES (:texte_res, :est_correcte, :id_question)";

        $stmt = self::$db->prepare($insererReponse);
        $stmt->bindParam(':texte_res', $reponse);
        $stmt->bindParam(':est_correcte', $est_correcte);
        $stmt->bindParam(':id_question', $id_question);

        foreach ($questions as $question) {
            if (is_array($question['answer'])) {
                foreach ($question['answer'] as $reponse_courante) {
                    $verifierReponse = "SELECT COUNT(*) FROM Reponse WHERE Texte_reponse = :texte_res AND ID_question = :id_question";
                    $stmtVerif = self::$db->prepare($verifierReponse);
                    $stmtVerif->bindParam(':texte_res', $reponse_courante);
                    $stmtVerif->bindParam(':id_question', $question['id']);
                    $reponseCompte = $stmtVerif->fetchColumn();
                    if ($reponseCompte == 0) {
                        $reponse = $reponse_courante;
                        $id_question = $question['id'];
                        $stmt->execute();
                    }
                }
            } else {
                $verifierReponse = "SELECT COUNT(*) FROM Reponse WHERE Texte_reponse = :texte_res AND ID_question = :id_question";
                $stmtVerif = self::$db->prepare($verifierReponse);
                $stmtVerif->bindParam(':texte_res', $question['answer']);
                $stmtVerif->bindParam(':id_question', $question['id']);
                $reponseCompte = $stmtVerif->fetchColumn();
                if ($reponseCompte == 0) {
                    $reponse = $question['answer'];
                    $id_question = $question['id'];
                    $stmt->execute();
                }
            }
        }
    }

    function inserer_choix($questions) {
        $texte_choix = null;
        $valeur_choix = null;
        $id_question = null;

        $insererChoix = "INSERT INTO Choix (Texte_choix, Value_choix, ID_question) VALUES (:texte_choix, :valeur_choix, :id_question)";

        $stmt = self::$db->prepare($insererChoix);
        $stmt->bindParam(':texte_choix', $texte_choix);
        $stmt->bindParam(':valeur_choix', $valeur_choix);
        $stmt->bindParam(':id_question', $id_question);

        foreach ($questions as $question) {
            if (isset($question['choices'])) {
                foreach ($question['choices'] as $choix_courant) {
                    $verifierChoix = "SELECT COUNT(*) FROM Choix WHERE ID_question = :id_question AND Texte_choix = :texte_choix";
                    $stmtVerif = self::$db->prepare($verifierChoix);
                    $stmtVerif->bindParam(':id_question', $question['id']);
                    $stmtVerif->bindParam(':texte_choix', $choix_courant['text']);
                    $choixCompte = $stmtVerif->fetchColumn();
                    if ($choixCompte == 0) {
                        $texte_choix = $choix_courant['text'];
                        $valeur_choix = $choix_courant['value'];
                        $id_question = $question['id'];
                        $stmt->execute();
                    }
                }
            }
        }
    }

    function creer_questions() {
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
