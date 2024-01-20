<?php 

namespace quiz\question;

use form\type\Text;

class TextQuestion extends Question{

    public function __construct(string $uuid, 
        string $label, string $answer
    ){
        parent::__construct($uuid, $label, $answer);
    }

    public function render(): string{
        $question = $this->label;
        $question .= "<div class='answer'>";
        $question .= new Text("", true, $this->uuid, "");
        return $question."</div>";
    }
}