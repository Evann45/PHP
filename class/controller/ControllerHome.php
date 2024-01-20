<?php 

namespace controller;

class ControllerHome extends Controller{

    public function __construct(){
        
    }

    public function view(){
        $this->render("quiz.php", array(
            "question" => mt_rand(1, 100)
        ));
    }
}