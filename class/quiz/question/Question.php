<?php 

namespace quiz\question;

abstract class Question{

    public function __construct(
        protected string $uuid,
        protected string $label,
        protected string $answer
    ){
        
    }

    public function getUuid(): string{
        return $this->uuid;
    }

    public function __toString(){
        return "<div class='question'>".$this->render()."</div>";
    }

    abstract public function render(): string;
}