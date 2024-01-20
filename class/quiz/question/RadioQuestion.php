<?php 

namespace quiz\question;

use form\type\RadioButton;

class RadioQuestion extends Question{

    private array $choices;

    public function __construct(string $uuid, 
        string $label, string $answer, 
        array $choices
    ){
        $this->choices = $choices;
        parent::__construct($uuid, $label, $answer);
    }

    public function render(): string{
        $question = $this->label;
        $question .= "<div class='answer'>";
        foreach($this->choices as $choice){
            $question .= new RadioButton($choice, true, $this->uuid, $choice);
        }
        return $question."</div>";
    }
}