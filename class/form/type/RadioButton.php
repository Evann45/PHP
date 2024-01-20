<?php 

namespace form\type;

class RadioButton extends Input{

    protected string $type = "radio";

    public function render(): string{
        return parent::render()."<label for=".$this->id.">".$this->value."</label>";
    }
}