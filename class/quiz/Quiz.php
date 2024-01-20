<?php 

namespace quiz;

use form\type\Button;
use quiz\question\RadioQuestion;
use quiz\question\TextQuestion;

class Quiz{

    private array $questions = [];

    private int $questionTotal = 0;
    private int $questionCorrect = 0;
    private int $scoreTotal = 0;
    private int $scoreCorrect = 0;

    public function __construct(array $questions){
        $this->questions = $questions;
    }

    public function getQuestions(): array{
        return $this->questions;
    }

    public function valide(){

    }

    public function __toString(): string{
        $html = "";
        foreach($this->questions as $question){
            $html .= $question."<br>";
        }
        $html .= new Button("Valider", true, "", "");
        return $html;
    }
}