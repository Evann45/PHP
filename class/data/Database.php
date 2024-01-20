<?php 

namespace data;

use PDO;
use PDOStatement;

class Database{

    private PDO $db;

    private static $instance = null;

    private function __construct(){
        $this->db = new PDO('sqlite:bd.sqlite3');
        $this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    }

    public function query(string $query): ?PDOStatement{
        return $this->db->query($query);
    }

    public function close(): void{
        $this->db = null;
    }

    public static function getInstance(): self{
        if(self::$instance === null){
            self::$instance = new Database();
        }
        return self::$instance;
    }
}