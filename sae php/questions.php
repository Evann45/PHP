<?php 

        class Questionnaire{
            private $id;
            private $titre;
            private $listeQuestions;

            public function __construct($id,$titre,$liste){
                $this->id = $id;
                $this->titre = $titre;
                $this->listeQuestions = $liste;
            }

            public function getQuestions(){
                return $this->listeQuestions;
            }

            public function getId(){
                return $this->id;
            }

            public function getTitre(){
                return $this->titre;
            }

            public function afficher(){
                $output = "<a href = 'question.php?id=" . $this->id . "'> <div class = 'questionnaire'>" . $this->id . " " .  $this->titre .  "</div></a>";
                return $output;
            }
        }

        class QuestionAChoixMultiple {
            private $question;
            private $choix;
            private $reponse;
    
            public function __construct($question, $choix, $reponse) {
                $this->question = $question;
                $this->choix = $choix;
                $this->reponse = $reponse;
            }
        
            public function getReponse(){
                return $this->reponse;
            }
        
            public function checkreponse($submittedreponse) {
                return $submittedreponse === $this->reponse;
            }

            public function afficher($numero) {
                $output = "";
                $output .= "<label id ='Q" . $numero . "' for='Q". $numero ."'>" . $this->question . "</label>";
                foreach ($this->choix as $reponse){
                    $output .= "<input type ='radio' name = 'question" . $numero . "' value='". $reponse . "'>" . $reponse . "\n";
                }
                return $output;
            }

            public function afficherBonneReponse($numero) {
                $output = "";
                $output .= "<label style = 'color: #06CE59;' id ='Q" . $numero . "' for='Q". $numero ."'>" . $this->question . "</label>";
                $output .= "<p style = 'color: #06CE59;' > Bravo la bonne réponse était bien " . $this->reponse . " <p>";
                return $output;
            }

            public function afficherFausseReponse($numero,$submittedreponse) {
                $output = "";
                $output .= "<label style = 'color: #D23014;' id ='Q" . $numero . "' for='Q". $numero ."'>" . $this->question . "</label>";
                $output .= "<p style = 'color: #D23014;' > La bonne réponse était " . $this->reponse . " et non " . $submittedreponse . "<p>";
                return $output;
            }
        }
    
        class QuestionTexte {
            private $question;
            private $reponse;

        public function __construct($question,$reponse) {
            $this->question = $question;
            $this->reponse = $reponse;
        }

        public function getReponse(){
            return $this->reponse;
        }
    
        public function checkreponse($submittedreponse) {
            return $submittedreponse === $this->reponse;
        }

        public function afficher($numero) {
            $output = "";
            $output .= "<label id ='Q" . $numero . "' for='Q". $numero ."'>" . $this->question . "</label>";
            $output .= "<input type ='text' name = 'question" . $numero . "' requi#D23014 >\n";
            return $output;
        }

        public function afficherBonneReponse($numero) {
            $output = "";
            $output .= "<label style = 'color: #06CE59;' id ='Q" . $numero . "' for='Q". $numero ."'>" . $this->question . "</label>";
            $output .= "<p style = 'color: #06CE59;' > Bravo la bonne réponse était bien " . $this->reponse . " <p>";
            return $output;
        }

        public function afficherFausseReponse($numero,$submittedreponse) {
            $output = "";
            $output .= "<label style = 'color: #D23014;' id ='Q" . $numero . "' for='Q". $numero ."'>" . $this->question . "</label>";
            $output .= "<p style = 'color: #D23014;' > La bonne réponse était " . $this->reponse . " et non " . $submittedreponse . "<p>";
            return $output;
        }
        }

        class QuestionNumerique {
            private $question;
            private $reponse;
        
            public function __construct($question, $reponse) {
                $this->question = $question;
                $this->reponse = $reponse;
            }
        
            public function checkreponse($submittedreponse) {
                return $submittedreponse === $this->reponse;
            }

            public function getReponse(){
                return $this->reponse;
            }

            public function afficher($numero) {
                $output = "";
                $output .= "<label id ='Q" . $numero . "' for='Q". $numero ."'>" . $this->question . "</label>";
                $output .= "<input type ='number' name = 'question" . $numero . "' requi#D23014>\n";
                return $output;
            }

            public function afficherBonneReponse($numero) {
                $output = "";
                $output .= "<label style = 'color: #06CE59;' id ='Q" . $numero . "' for='Q". $numero ."'>" . $this->question . "</label>";
                $output .= "<p style = 'color: #06CE59;' > Bravo la bonne réponse était bien " . $this->reponse . " <p>";
                return $output;
            }

            public function afficherFausseReponse($numero,$submittedreponse) {
                $output = "";
                $output .= "<label style = 'color: #D23014;' id ='Q" . $numero . "' for='Q". $numero ."'>" . $this->question . "</label>";
                $output .= "<p style = 'color: #D23014;' > La bonne réponse était " . $this->reponse . " et non " . $submittedreponse . "<p>";
                return $output;
            }
        }
        
        class QuestionVraiFaux {
            private $question;
            private $reponse;
        
            public function __construct($question, $reponse) {
                $this->question = $question;
                $this->reponse = $reponse;
            }
        
            public function checkreponse($submittedreponse) {
                return $submittedreponse === $this->reponse;
            }

            public function getReponse(){
                return $this->reponse;
            }

            public function afficher($numero) {
                $output = "";
                $output .= "<label id ='Q" . $numero . "' for='Q". $numero ."'>" . $this->question . "</label>";
                $output .= "<input type ='radio' name = 'question" . $numero . "' value='VRAI'>" . "VRAI" . "\n";
                $output .= "<input type ='radio' name = 'question" . $numero . "' value='FAUX'>" . "FAUX" . "\n";
                return $output;
            }

            public function afficherBonneReponse($numero) {
                $output = "";
                $output .= "<label style = 'color: #06CE59;' id ='Q" . $numero . "' for='Q". $numero ."'>" . $this->question . "</label>";
                $output .= "<p style = 'color: #06CE59;' > Bravo la bonne réponse était bien " . $this->reponse . " <p>";
                return $output;
            }

            public function afficherFausseReponse($numero,$submittedreponse) {
                $output = "";
                $output .= "<label style = 'color: #D23014;' id ='Q" . $numero . "' for='Q". $numero ."'>" . $this->question . "</label>";
                $output .= "<p style = 'color: #D23014;' > La bonne réponse était " . $this->reponse . " et non " . $submittedreponse . "<p>";
                return $output;
            }
        }

        $listeQuestionnaires = array();

        include_once("connection.php");
        $stmt = $connexion->query("SELECT * FROM questionnaires");
        while ($row = $stmt->fetch()) {
            $stmtQuestions = $connexion->query("SELECT * FROM questions where questionnaire_id = " . $row['id']);
            $listeQuestions = array();
            while ($rowQ = $stmtQuestions->fetch()) {
                if($rowQ['type'] == "texte"){
                    $stmtChoix = $connexion->query("SELECT * FROM choixQuestions where question_id = " . $rowQ['id']);
                    while($rowC = $stmtChoix->fetch()){
                        $choixTexte = $rowC['choix'];
                    }
                    array_push($listeQuestions,new QuestionTexte($rowQ['texte'],$choixTexte));
                }
                else if($rowQ['type'] == "choix multiple"){
                    $stmtChoix = $connexion->query("SELECT * FROM choixQuestions where question_id = " . $rowQ['id']);
                    $listeChoix = array();
                    while($rowC = $stmtChoix->fetch()){
                        $choixTexte = $rowC['choix'];
                        $juste = $rowC['juste'];
                        if($juste){
                            $choixJusteTexte = $choixTexte;
                        }
                        array_push($listeChoix,$choixTexte);
                    }
                    array_push($listeQuestions,new QuestionAChoixMultiple($rowQ['texte'],$listeChoix,$choixJusteTexte));
                }
                else if($rowQ['type'] == "vrai ou faux"){
                    $stmtChoix = $connexion->query("SELECT * FROM choixQuestions where question_id = " . $rowQ['id']);
                    while($rowC = $stmtChoix->fetch()){
                        $choixTexte = $rowC['choix'];
                    }
                    array_push($listeQuestions,new QuestionVraiFaux($rowQ['texte'],$choixTexte));
                }
                else if($rowQ['type'] == "numerique"){
                    $stmtChoix = $connexion->query("SELECT * FROM choixQuestions where question_id = " . $rowQ['id']);
                    while($rowC = $stmtChoix->fetch()){
                        $choixTexte = $rowC['choix'];
                    }
                    array_push($listeQuestions,new QuestionNumerique($rowQ['texte'],$choixTexte));
                }
            }   

            array_push($listeQuestionnaires,new Questionnaire($row['id'],$row['titre'],$listeQuestions));
        }
    ?>


