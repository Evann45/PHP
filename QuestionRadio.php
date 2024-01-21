<?php

namespace QuizzFolder\Type;

require_once  './InputRadio.php';
require_once  './GeneriqueFormElement.php';

use QuizzFolder\Question;
use Classes\Form\Type\InputRadio;

class QuestionRadio extends Question {
    public function __construct(string $nom, string $texte, array $reponse, array $choix, $score) {
        parent::__construct($nom, $texte, $reponse, $choix, $score);
    }

    public function questionRadio($index) {
        $html = "<br>";
        $i = 0;
        foreach (parent::getChoix() as $c) {
            $i += 1;
            $questionRadio = new InputRadio("q{$index}_$i", "q$index", $c['Texte_choix'], "q{$index}_$i", true);
            $render = $questionRadio->rendu();
            $html .= $render;
        }
        return $html;
    }

    public function calculerPoints($q, $v) {
        $scoreTotal = 0;
        $scoreCorrect = 0;

        $scoreTotal += $q->getScore();

        if (is_null($v)) return;

        $reponsesCorrectes = $q->getReponse();
        $reponsesDonnees = is_array($v) ? $v : array($v);

        if ($reponsesCorrectes[0]['Texte_reponse'] == strtolower($reponsesDonnees[0])) {
            // nous pouvons accéder à [0]['Texte_reponse'] car de toute façon c'est une question radio donc une seule réponse possible
            $scoreCorrect += $q->getScore();
        }

        return [$scoreCorrect, $scoreTotal];
    }

    public function rendu($index) {
        return $this->questionRadio($index);
    }
}

?>
