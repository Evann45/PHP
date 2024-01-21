<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php

require_once   './ConnexionBD.php';
require_once   './Question.php';
require_once   './QuestionText.php';
require_once   './QuestionRadio.php';
require_once   './QuestionCheckbox.php';
require_once   './RequeteBDD.php';

use QuizzFolder\Type\QuestionText;
use QuizzFolder\Type\QuestionRadio;
use QuizzFolder\Type\QuestionCheckbox;
use BD\RequeteBDD;
use BD\ConnexionBD;

// Initialisation de la connexion à la base de données
$db = new ConnexionBD();
$requete = new RequeteBDD("Quizz");

// Récupération de la liste des quizz
$res_quizz = $requete->recup_datas($db::obtenir_connexion());
$liste_quizz = $res_quizz->fetchAll(PDO::FETCH_ASSOC);

// Récupération des questions
$requete->set_table("Question");
$res_question = $requete->recup_datas($db::obtenir_connexion());
$liste_questions = $res_question->fetchAll(PDO::FETCH_ASSOC);

function construit_responses($liste_questions, $requete, $db, $id_quizz) {
    $liste_questions_a_afficher = [];

    // Récupération des questions spécifiques à un quizz
    $res_question = $requete->recup_questions_by_id_quizz($db::obtenir_connexion(), $id_quizz);
    $liste_questions = $res_question->fetchAll(PDO::FETCH_ASSOC);

    foreach ($liste_questions as $question) {
        // Récupération des réponses
        $responses = $requete->recup_reponses_by_id_question($db::obtenir_connexion(), $question['ID_question']);
        $liste_reponses = $responses->fetchAll(PDO::FETCH_ASSOC);

        // Récupération des choix (pour les questions de type radio ou checkbox)
        $choices = $requete->recup_choices_by_id_question($db::obtenir_connexion(), $question['ID_question']);
        $liste_choices = $choices->fetchAll(PDO::FETCH_ASSOC);

        // Création des objets QuestionText, QuestionRadio, ou QuestionCheckbox selon le type de question
        if ($question['Type_question'] == 'text') {
            $current_question = new QuestionText($question['Nom_question'], 
                                                 $question['Texte_question'], 
                                                 $liste_reponses,
                                                 [], 
                                                 $question['Points_gagnes']
            );
            $liste_questions_a_afficher[] = $current_question;
        }
        else if ($question['Type_question'] == 'radio') {
            $current_question = new QuestionRadio($question['Nom_question'], 
                                                 $question['Texte_question'], 
                                                 $liste_reponses,
                                                 $liste_choices, 
                                                 $question['Points_gagnes']
            );
            $liste_questions_a_afficher[] = $current_question;
        }
        else if ($question['Type_question'] == 'checkbox') {
            $current_question = new QuestionCheckbox($question['Nom_question'], 
                                                 $question['Texte_question'], 
                                                 $liste_reponses,
                                                 $liste_choices, 
                                                 $question['Points_gagnes']
            );
            $liste_questions_a_afficher[] = $current_question;
        }
    }

    return $liste_questions_a_afficher;
}

// Affichage des formulaires pour chaque quizz
foreach ($liste_quizz as $index_quizz => $quizz) {
    $liste_questions_a_afficher = construit_responses($liste_questions, $requete, $db, $index_quizz+1);
    ?>
    <form method="post" action="verifie_reponse.php">
        <h3><?= $quizz['name_quizz'] ?></h3>
        <?php foreach ($liste_questions_a_afficher as $index => $question): ?>
            <div class="question-container">
                <h4><?= $question->getTexte() ?></h4>
                <?= $question->rendu($index) ?>
            </div>
        <?php endforeach; ?>
        <br>

        <br>
        <input type="submit" value="Soumettre vos réponses">
    </form>
    <?php
}

?>

<!-- Formulaire de création de quizz -->
<form method="post" action="creation_quizz.php">
    <input type="hidden" name="redirection" value="false">
    <h3>Créer votre propre quizz dès maintenant</h3>
    <input class="form_creation_quizz" type="submit" value="Créer un quizz">
</form>

</body>
</html>
