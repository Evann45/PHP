<?php

namespace QuizzFolder\Type;

require_once './InputCheckbox.php';
require_once './GeneriqueFormElement.php';

use QuizzFolder\Question;
use Classes\Form\Type\InputCheckbox;

class QuestionCheckbox extends Question {
    public function __construct(string $nom, string $texte, array $reponse, array $choix, $score) {
        parent::__construct($nom, $texte, $reponse, $choix, $score);
    }

    public function questionCheckbox($index) {
        $html = "<br>";
        $i = 0;
        foreach (parent::getChoix() as $c) {
            $i += 1;
            $questionCheckbox = new InputCheckbox("q{$index}_$i", "q$index", $c['Texte_choix'], "q{$index}_$i", true);
            $render = $questionCheckbox->rendu();
            $html .= $render;
        }
        return $html;
    }

    public function calculerPoints($q, $v) {
        $scoreTotal = 0;
        $scoreCorrect = 0;

        $scoreTotal += $q->getScore();

        if (is_null($v)) return 0;

        $reponsesCorrectes = $q->getReponse();
        $reponsesDonnees = is_array($v) ? $v : array($v);

        foreach ($reponsesDonnees as $index => $reponse) {
            foreach ($reponsesCorrectes as $key => $value) {
                if ($reponsesCorrectes[$key]['Texte_reponse'] == strtolower($reponse)) { // strtolower permet de mettre en minuscule
                    $scoreCorrect += $q->getScore() / sizeof($reponsesCorrectes);
                }
            }
        }

        return [$scoreCorrect, $scoreTotal];
    }

    public function rendu($index) {
        return $this->questionCheckbox($index);
    }
}

?>
