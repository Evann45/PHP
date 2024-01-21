<?php

namespace QuizzFolder\Type;

require_once __DIR__ . '/InputText.php';
require_once __DIR__ . '/GeneriqueFormElement.php';

use QuizzFolder\Question;
use Classes\Form\Type\InputText;

class QuestionText extends Question {
    public function __construct(string $nom, string $texte, array $reponse, array $choix, $score) {
        parent::__construct($nom, $texte, $reponse, $choix, $score);
    }

    public function questionText($index) {
        $html = "<br>";
        $questionText = new InputText("q{$index}", "q$index", "", "", true);
        $render = $questionText->rendu();
        $html .= $render;
        $html .= "<br>";
        return $html;
    }

    public function calculerPoints($q, $v) {
        $scoreTotal = 0;
        $scoreCorrect = 0;

        $scoreTotal += $q->getScore();

        if (is_null($v)) return 0;

        if ($q->getReponse()[0] == $v) {
            $scoreCorrect += $q->getScore();
        }

        return [$scoreCorrect, $scoreTotal];
    }

    public function rendu($index) {
        return $this->questionText($index);
    }
}

?>
