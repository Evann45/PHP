<?php

namespace QuizzFolder\Type;

require_once __DIR__ . '/InputText.php';
require_once __DIR__ . '/GeneriqueFormElement.php';

use QuizzFolder\Question;
use Classes\Form\Type\InputText;

class QuestionText extends Question {
    public function __construct(string $name, string $text, array $answer, array $choices, $score) {
        parent::__construct($name, $text, $answer, $choices, $score);
    }
    public function question_text($index) {
        $html = "<br>";
        $question_text = new InputText("q{$index}", "q$index", "", "", true);
        $render = $question_text->render();
        $html .= $render;
        $html .= "<br>";
        return $html;
    }
    
    function calcul_points($q, $v) {
        $score_total = 0;
        $score_correct = 0;

        $score_total += $q->getScore(); 

        if (is_null($v)) return 0;
        
        if ($q->getAnswer()[0] == $v) { 
            $score_correct += $q->getScore(); 
        }

        return [$score_correct, $score_total];
    }

    public function rendu($index) {
        return $this->question_text($index);
    }
}

?>