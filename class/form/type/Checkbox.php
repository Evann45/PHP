<?php 

namespace form\type;

class Checkbox extends Input{

    protected string $type = "checkbox";  
    
    public function render(): string{
        return parent::render()."<label for=".$this->id.">".$this->value."</label>";
    }
}