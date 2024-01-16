<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="formulaire.css">
    <title>Réponses</title>
</head>
<body>
    
</body>
</html>
<?php 


        session_start();
        if (!isset($_SESSION['score' . $_GET['id']])) {
            $_SESSION['score' . $_GET['id']] = 0;
        }

        include_once('questions.php');
        $compteur = 1;
        $affichage= "<form>";
        $score = 0;
        foreach ($listeQuestionnaires as $questionnaires){
            if($questionnaires->getId() == $_GET['id']){
                foreach ($questionnaires->getQuestions() as $question){
                    if($question->checkreponse($_REQUEST['question' . $compteur])){
                        $affichage.= $question->afficherBonneReponse($compteur);
                        $compteur += 1;
                        $score += 1;
                    }
                    else{
                        $affichage.= $question->afficherFausseReponse($compteur,$_REQUEST['question' . $compteur]);
                        $compteur += 1;
                    }
            }
            }
    }
    if($compteur == 1){
        echo $compteur;
        header("Location: question.php?id=" . $_GET['id']);
    }
    if($score > $_SESSION['score' . $_GET['id']]){
        $_SESSION['score' . $_GET['id']] = $score;
    }
    $_SESSION['dernierScore' . $_GET['id']] = $score;
    
        if ($score >= ($compteur-1) / 2){
            $affichage .= "<p style = 'color: #06CE59;'> Félicitations, vous finissez donc ce quizz avec un score de " . $score . "/" . $compteur - 1 . " !";
        }
        else{
            $affichage .= "<p style = 'color: #D23014;'> Dommage, vous finissez donc ce quizz avec un score de " . $score . "/" . $compteur - 1 . " !";
        }
        $affichage.= "</form>";
        echo $affichage;

        $bouton = "<button><a href = questionnaires.php>Retourner aux questionnaires</a></button>";
        
        echo $bouton;

        echo "<div id = score>";
        echo "<p>Votre score meilleur score est : ".$_SESSION['score' . $_GET['id']] . "</p>";
        echo "<p>Votre dernier score est : ".$_SESSION['dernierScore' . $_GET['id']] . "</p>";
        echo "</div>";

?>