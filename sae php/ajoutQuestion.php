<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="formulaire.css">
    <title>Créer question</title>
</head>
<body>
    
</body>
<script>
    function ajouterChoix() {
        var choixDiv = document.createElement("div");
        choixDiv.innerHTML = "<input type='text' name='choix[]' required>";
        document.querySelector("div label:last-of-type").insertAdjacentElement("afterend", choixDiv);
    }
</script>
</html>
<?php 

    if ($_REQUEST['typeQuestion'] == 'vraiFaux'){
        $ajouterQuestion = "<form method='POST' action='ajouterQuestion.php?id=" . $_GET['id'] . "&typeQuestion=" . $_REQUEST['typeQuestion'] . "&nomQuestion=" . $_REQUEST['nomQuestion'] . "'>";
        $ajouterQuestion .= "<label> Réponse <label>";
        $ajouterQuestion .= "<select name='reponseVraiFaux'>
                                <option value='VRAI'>Vrai</option>
                                <option value='FAUX'>Faux</option>
                            </select>";
        $ajouterQuestion .= "<input type='submit' value='Ajouter la question'>";
        $ajouterQuestion .= "</form>";
        echo $ajouterQuestion;
    }
    else if ($_REQUEST['typeQuestion'] == 'qcm'){
        $ajouterQuestion = "<form method='POST' action='ajouterQuestion.php?id=" . $_GET['id'] . "&typeQuestion=" . $_REQUEST['typeQuestion'] . "&nomQuestion=" . $_REQUEST['nomQuestion'] . "'>";
        $ajouterQuestion .=     "<div>
                            <label>Choix de réponse</label>
                            <input type='text' name='choix[]' required>
                            <button type='button' onclick='ajouterChoix()'>Ajouter un choix</button>
                                </div>";
        
        $ajouterQuestion .= "<label> Réponse <label>";
        $ajouterQuestion .= "<input type='text' name='reponseQCM' required>";
        $ajouterQuestion .= "<input type='submit' value='Ajouter la question'>";
        $ajouterQuestion .= "</form>";
        echo $ajouterQuestion;
    }

    else if($_REQUEST['typeQuestion'] == 'texte'){
        $ajouterQuestion = "<form method='POST' action='ajouterQuestion.php?id=" . $_GET['id'] . "&typeQuestion=" . $_REQUEST['typeQuestion'] . "&nomQuestion=" . $_REQUEST['nomQuestion'] . "'>";
        $ajouterQuestion .= "<label> Réponse <label>";
        $ajouterQuestion .= "<input type='text' name='reponseTexte' required>";
        $ajouterQuestion .= "<input type='submit' value='Ajouter la question'>";
        $ajouterQuestion .= "</form>";
        echo $ajouterQuestion;
    }
    else if($_REQUEST['typeQuestion'] == 'numerique'){
        $ajouterQuestion = "<form method='POST' action='ajouterQuestion.php?id=" . $_GET['id'] . "&typeQuestion=" . $_REQUEST['typeQuestion'] . "&nomQuestion=" . $_REQUEST['nomQuestion'] . "'>";
        $ajouterQuestion .= "<label> Réponse <label>";
        $ajouterQuestion .= "<input type='number' name='reponseNumerique' required>";
        $ajouterQuestion .= "<input type='submit' value='Ajouter la question'>";
        $ajouterQuestion .= "</form>";
        echo $ajouterQuestion;
    }
?>