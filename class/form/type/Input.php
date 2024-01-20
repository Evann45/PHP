<?php 

namespace form\type;

use form\InputRender;

abstract class Input implements InputRender{

    protected string $type;

    public function __construct(
        protected string $value,
        private bool $required,
        private string $name,
        protected string $id
    ){}

    public function __toString() {
        return $this->render();
    }

    public function render(): string{
        $required = $this->required ? "required=true" : "";
        $value = $this->value === "" ? "" : "value=".$this->value;
        return "<input type=".$this->type." $required $value id=".$this->id." name=".$this->name.">";
    }
}