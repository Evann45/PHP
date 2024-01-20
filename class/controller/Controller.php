<?php 

namespace controller;

class Controller{

    public function render(string $view, array $variable = []){
        extract($variable);
        require "view/".$view;
    }
}