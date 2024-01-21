<?php

require_once  './ConnexionBD.php';
require_once  './Question.php';
require_once  './QuestionText.php';
require_once  './QuestionRadio.php';
require_once  './QuestionCheckbox.php';
require_once  './RequeteBDD.php';
require_once  './verifie_reponse.php';

use QuizzFolder\Type\QuestionText;
use QuizzFolder\Type\QuestionRadio;
use QuizzFolder\Type\QuestionCheckbox;
use BD\RequeteBDD;
use BD\ConnexionBD;

$db = new ConnexionBD();

$requete = new RequeteBDD("Question");
$liste_questions = $requete->recup_datas($db::obtenir_connexion())->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat du Quizz</title>
    <link rel="stylesheet" href="style_rep.css">
</head>
<body>

<h2>Résultat du Quizz</h2>
<div class="quiz-result">
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $score = 0;
            $score_total = 0;
            foreach ($liste_questions as $index => $question_data) {
                $bonne_rep = $requete->recup_reponses_by_id_question($db::obtenir_connexion(), $question_data['ID_question'])->fetchAll(PDO::FETCH_ASSOC);
                $reponses_donnees = isset($_POST["q$index"]) ? $_POST["q$index"] : '';
        
                if ($question_data['Type_question'] == 'texte') {
                    $question_text = new QuestionText(
                        $question_data['Nom_question'],
                        $question_data['Texte_question'],
                        array($reponses_donnees),
                        array(),
                        $question_data['Points_gagnes'] != null ? $question_data['Points_gagnes'] : 0
                    );
                    $res_text = $question_text->calculerPoints($question_text, $bonne_rep[0]['Texte_reponse']);
                    $score += $res_text[0];
                    $score_total += $res_text[1];
                }

                else if ($question_data['Type_question'] == 'radio') {
                    $liste_choices = $requete->recup_choices_by_id_question($db::obtenir_connexion(), $question_data['ID_question'])->fetchAll(PDO::FETCH_ASSOC);
                    $question_radio = new QuestionRadio(
                        $question_data['Nom_question'],
                        $question_data['Texte_question'],
                        $bonne_rep,
                        $liste_choices,
                        $question_data['Points_gagnes'] != null ? $question_data['Points_gagnes'] : 0
                    );
                    $res_radio = $question_radio->calculerPoints($question_radio, $reponses_donnees);
                    $score += $res_radio[0];
                    $score_total += $res_radio[1];
                }

                else if ($question_data['Type_question'] == 'checkbox') {
                    $liste_choices = $requete->recup_choices_by_id_question($db::obtenir_connexion(), $question_data['ID_question'])->fetchAll(PDO::FETCH_ASSOC);
                    $question_checkbox = new QuestionCheckbox(
                        $question_data['Nom_question'],
                        $question_data['Texte_question'],
                        $bonne_rep,
                        $liste_choices,
                        $question_data['Points_gagnes'] != null ? $question_data['Points_gagnes'] : 0
                    );
                    $res_checkbox = $question_checkbox->calculerPoints($question_checkbox, $reponses_donnees);
                    $score += $res_checkbox[0];
                    $score_total += $res_checkbox[1];
                }
        
            }
            echo "<h2>Votre avez $score / $score_total</h2>";
        }
    ?>
     <a href="./index.php"><button type="submit" name="reset_score">Retour</button></a>
</div>

</body>
</html>
