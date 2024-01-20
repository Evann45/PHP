<?php

// utilisation du pattern singleton

namespace repository;

use quiz\question\Question;

class QuestionRepository{

    private static $instance = null;

    private array $questions = [];

    private function __construct(){}

    public function add(Question $question): void{
        $this->questions[] = $question;
    }

    public function remove(Question $question): bool{
        foreach($this->questions as $index => $q){
            if($q->getUuid() === $question->getUuid()){
                unset($this->questions[$index]);
                return true;
            }
        }
        return false;
    }

    public function getAll(): array{
        return $this->questions;
    }

    public static function getInstance(): self{
        if(self::$instance === null){
            self::$instance = new QuestionRepository();
        }
        return self::$instance;
    }
}