<?php

namespace DossierQuizz;

class Choix {

    private int $idChoix;
    private string $texte;
    private string $valeur;
    private int $idQuestion;

    public function __construct(int $idChoix, string $texte, string $valeur, int $idQuestion) {
        $this->idChoix = $idChoix;
        $this->texte = $texte;
        $this->valeur = $valeur;
        $this->idQuestion = $idQuestion;
    }

    public function getIdChoix(): int {
        return $this->idChoix;
    }

    public function getTexte(): string {
        return $this->texte;
    }

    public function getValeur(): string {
        return $this->valeur;
    }

    public function getIdQuestion(): int {
        return $this->idQuestion;
    }
}

?>
