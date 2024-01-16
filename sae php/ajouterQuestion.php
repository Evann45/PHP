<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="formulaire.css">
    <title>Ajouter Questions</title>
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
    include_once('connection.php');

    if ($_REQUEST['typeQuestion'] == 'texte'){
        $maxID = $connexion->prepare("SELECT MAX(id) AS max_id FROM questions");
        $maxID->execute();
        $result = $maxID->fetch(PDO::FETCH_ASSOC);
    
        $idMaxQuestion = $result['max_id'];
    
        $sql = "INSERT INTO questions (id, questionnaire_id, type,texte) VALUES (?, ?, ?, ?)";
        $ajoutQuestionnaire = $connexion->prepare($sql);
        $ajoutQuestionnaire->execute([$idMaxQuestion + 1, $_REQUEST['id'], 'texte',$_REQUEST['nomQuestion']]);
        
        $maxID = $connexion->prepare("SELECT MAX(id) AS max_id FROM choixQuestions");
        $maxID->execute();
        $result = $maxID->fetch(PDO::FETCH_ASSOC);
    
        $idMax = $result['max_id'];
        $choixT = "INSERT INTO choixQuestions (id , question_id,choix,juste) VALUES (?, ?, ?, ?)";
        $ajoutChoix = $connexion->prepare($choixT);
        $ajoutChoix->execute([$idMax + 1,$idMaxQuestion + 1,$_REQUEST['reponseTexte'],true]);

        $data = array(
            'questionnaire_id' => $idMax + 1,
            'question_id' => $idMaxQuestion + 1,
            'choix' => $_REQUEST['reponseTexte'],
            'juste' => true,
            'type' => 'texte'
          );
          $json = file_get_contents('question.json');
          $jsonArray = json_decode($json, true);
          $jsonArray[] = $data;
          $json = json_encode($jsonArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
          file_put_contents('question.json', $json);

        header("Location: choixTypeQuestion.php?id=" . $_REQUEST['id']);
        exit;
    }
    else if($_REQUEST['typeQuestion'] == 'vraiFaux'){
        $maxID = $connexion->prepare("SELECT MAX(id) AS max_id FROM questions");
        $maxID->execute();
        $result = $maxID->fetch(PDO::FETCH_ASSOC);
    
        $idMaxQuestion = $result['max_id'];
    
        $sql = "INSERT INTO questions (id, questionnaire_id, type,texte) VALUES (?, ?, ?, ?)";
        $ajoutQuestionnaire = $connexion->prepare($sql);
        $ajoutQuestionnaire->execute([$idMaxQuestion + 1, $_REQUEST['id'], 'vrai ou faux',$_REQUEST['nomQuestion']]);
        
        $maxID = $connexion->prepare("SELECT MAX(id) AS max_id FROM choixQuestions");
        $maxID->execute();
        $result = $maxID->fetch(PDO::FETCH_ASSOC);
    
        $idMax = $result['max_id'];
        $choixV = "INSERT INTO choixQuestions (id , question_id,choix,juste) VALUES (?, ?, ?, ?)";
        $ajoutChoix = $connexion->prepare($choixV);
        $ajoutChoix->execute([$idMax + 1,$idMaxQuestion + 1,$_REQUEST['reponseVraiFaux'],true]);

        $data = array(
            'questionnaire_id' => $idMax + 1,
            'question_id' => $idMaxQuestion + 1,
            'choix' => $_REQUEST['reponseVraiFaux'],
            'juste' => true,
            'type' => 'Vrai ou Faux'
          );
          
 
          $json = file_get_contents('question.json');
          $jsonArray = json_decode($json, true);
          $jsonArray[] = $data;
          $json = json_encode($jsonArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        file_put_contents('question.json', $json);
        header("Location: choixTypeQuestion.php?id=" . $_REQUEST['id']);
        exit;
    }
    else if($_REQUEST['typeQuestion'] == 'numerique'){
        $maxID = $connexion->prepare("SELECT MAX(id) AS max_id FROM questions");
        $maxID->execute();
        $result = $maxID->fetch(PDO::FETCH_ASSOC);
    
        $idMaxQuestion = $result['max_id'];
    
        $sql = "INSERT INTO questions (id, questionnaire_id, type,texte) VALUES (?, ?, ?, ?)";
        $ajoutQuestionnaire = $connexion->prepare($sql);
        $ajoutQuestionnaire->execute([$idMaxQuestion + 1, $_REQUEST['id'], 'numerique',$_REQUEST['nomQuestion']]);
        
        $maxID = $connexion->prepare("SELECT MAX(id) AS max_id FROM choixQuestions");
        $maxID->execute();
        $result = $maxID->fetch(PDO::FETCH_ASSOC);
    
        $idMax = $result['max_id'];
        $choix = "INSERT INTO choixQuestions (id , question_id,choix,juste) VALUES (?, ?, ?, ?)";
        $ajoutChoix = $connexion->prepare($choix);
        $ajoutChoix->execute([$idMax + 1,$idMaxQuestion + 1,$_REQUEST['reponseNumerique'],true]);

        $data = array(
            'questionnaire_id' => $idMax + 1,
            'question_id' => $idMaxQuestion + 1,
            'choix' => $_REQUEST['reponseNumerique'],
            'juste' => true,
            'type' => 'Numerique'
          );
          
 
          $json = file_get_contents('question.json');
          $jsonArray = json_decode($json, true);
          $jsonArray[] = $data;
          $json = json_encode($jsonArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
          file_put_contents('question.json', $json);

        header("Location: choixTypeQuestion.php?id=" . $_REQUEST['id']);
        exit;
    }
    else if($_REQUEST['typeQuestion'] == 'qcm'){

        if (!(in_array($_REQUEST['reponseQCM'], $_REQUEST['choix']))){
            header("Location: ajoutQuestion.php?id=" . $_REQUEST['id'] . "&typeQuestion=" . $_REQUEST['typeQuestion']);
            exit();
        }

        $maxID = $connexion->prepare("SELECT MAX(id) AS max_id FROM questions");
        $maxID->execute();
        $result = $maxID->fetch(PDO::FETCH_ASSOC);
    
        $idMaxQuestion = $result['max_id'];
    
        $sql = "INSERT INTO questions (id, questionnaire_id, type,texte) VALUES (?, ?, ?, ?)";
        $ajoutQuestionnaire = $connexion->prepare($sql);
        $ajoutQuestionnaire->execute([$idMaxQuestion + 1, $_REQUEST['id'], 'choix multiple',$_REQUEST['nomQuestion']]);
        
        $maxID = $connexion->prepare("SELECT MAX(id) AS max_id FROM choixQuestions");
        $maxID->execute();
        $result = $maxID->fetch(PDO::FETCH_ASSOC);
    
        $idMax = $result['max_id'] + 1;
        foreach($_REQUEST['choix'] as $choix){
            $choixA = "INSERT INTO choixQuestions (id , question_id,choix,juste) VALUES (?, ?, ?, ?)";
            $ajoutChoix = $connexion->prepare($choixA);
            if($choix == $_REQUEST['reponseQCM']){
                $ajoutChoix->execute([$idMax,$idMaxQuestion + 1,$_REQUEST['reponseQCM'],true]);
                $idMax += 1;

                $data = array(
                    'questionnaire_id' => $idMax,
                    'question_id' => $idMaxQuestion + 1,
                    'choix' => $_REQUEST['reponseQCM'],
                    'juste' => true,
                    'type' => 'QCM'
                  );
                  
         
                  $json = file_get_contents('question.json');
                  $jsonArray = json_decode($json, true);
                  $jsonArray[] = $data;
                  $json = json_encode($jsonArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                
                  file_put_contents('question.json', $json);

            }
            else{
                $ajoutChoix->execute([$idMax,$idMaxQuestion + 1,$choix,false]);
                $idMax += 1;

                $data = array(
                    'questionnaire_id' => $idMax,
                    'question_id' => $idMaxQuestion + 1,
                    'choix' => $_REQUEST['reponseQCM'],
                    'juste' => false,
                    'type' => 'QCM'
                  );
                  
         
                $json = file_get_contents('question.json');
                $jsonArray = json_decode($json, true);
                $jsonArray[] = $data;
                $json = json_encode($jsonArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
              
                file_put_contents('question.json', $json);

            }
        }

        header("Location: choixTypeQuestion.php?id=" . $_REQUEST['id']);
        exit;
    }
    
    exit;

    // A FAIRE 
?>