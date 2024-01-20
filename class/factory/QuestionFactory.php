<?php 

//utilisation du pattern singleton 

namespace factory;

use data\Database;
use data\Dataloader;
use exception\ParametreException;
use PDO;
use quiz\question\RadioQuestion;
use quiz\question\TextQuestion;
use quiz\Quiz;
use repository\QuestionRepository;

class QuestionFactory{

    private QuestionRepository $repository;

    private static $instance = null;

    private function __construct(){}

    public static function getInstance(): self{
        if(self::$instance === null){
            self::$instance = new QuestionFactory(QuestionRepository::getInstance());
        }
        return self::$instance;
    }

    public function create(string $file): Quiz{
        $statement = Database::getInstance()->query("SELECT * FROM questions");
        $questions = $statement->fetchAll();
        foreach($questions as $question){
            if(!isset($question["typereponse"]))continue;
            switch($question["typereponse"]){
                case "radio":
                    $this->createRadioQuestion($question);break;
                case "text":
                    $this->createTextQuestion($question);break;
            }
        }

        return new Quiz($this->repository->getAll());
    }

    public function createRadioQuestion($question): void{
        $choix = [];

        $statement = Database::getInstance()->query("SELECT reponse FROM reponse where question_id='".$question["id"]."'");
        $reponses = $statement->fetchAll(PDO::FETCH_COLUMN);
        foreach($reponses as $reponse){
            $choix[] = $reponse;
        }

        $this->repository->add(new RadioQuestion(
            $question["id"], 
            $question["question"], 
            $question["bonnereponse"],
            $choix
        ));
    }

    public function createTextQuestion($question): void{
 

        $this->repository->add(new TextQuestion(
            $question->uuid, 
            $question->label, 
            $question->correct
        ));
    }
}