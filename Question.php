<?php

namespace QuizzFolder;

abstract class Question {
    public string $nom;
    public string $type;
    public string $texte;
    private array $reponse;
    private array $choix;
    public int $score;

    public function __construct(string $nom, string $texte, array $reponse, array $choix, int $score) {
        $this->nom = $nom;
        $this->texte = $texte;
        $this->reponse = $reponse;
        $this->choix = $choix;
        $this->score = $score;
    }

    public function getReponse() {
        return $this->reponse;
    }

    public function getChoix() {
        return $this->choix;
    }

    public function getScore() {
        return $this->score;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getType() {
        return $this->type;
    }

    public function getTexte(): string {
        return $this->texte;
    }

    public function setReponse(array $reponses) {
        $this->reponse = $reponses;
    }

    public function setChoix(array $choix) {
        $this->choix = $choix;
    }

    public abstract function calculerPoints($q, $v);

    public abstract function rendu($index);
}

?>
