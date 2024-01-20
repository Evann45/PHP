<?php 

namespace form;

use form\type\Input;

class Form implements InputRender{

    public const POST = "POST";
    public const GET = "GET";

    /** @var Input[] */
    private array $input = [];

    public function __construct(
        private string $action,
        private string $method
    )
    {}

    public function addInput(Input $input): void{
        $this->input[] = $input;
    }

    public function __toString(){
        return $this->render();
    }

    public function render(): string{
        $form = "<form action=".$this->action." method=".$this->method.">";
        foreach($this->input as $input){
            $form .= "<div>".$input."</div>";
        }
        $form .= "</form>";
        return $form;
    }
}