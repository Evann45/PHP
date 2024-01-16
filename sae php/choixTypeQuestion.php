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
        
        $affichage = "<form method='POST' action='ajoutQuestion.php?id=" . $_GET['id'] . "'>
        <div>
            <label>Intitulé</label>
            <input class='text' type='text' name='nomQuestion'>
        </div>
        <div>
            <label>Type de question</label>
            <select name='typeQuestion'>
                <option value='vraiFaux'>Vrai ou Faux</option>
                <option value='qcm'>QCM</option>
                <option value='texte'>Question Texte</option>
                <option value='numerique'>Question Numérique</option>
            </select>
        </div>
        <input type='submit' value='Creer une question'>
    </form>";
    
    echo $affichage;

    $bouton = "<button><a href = question.php?id=" . $_GET['id'] . ">Retourner au questionnaire</a></button>";
        
    echo $bouton;

?>