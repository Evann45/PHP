<?php 

namespace data;

use quiz\question\RadioQuestion;
use quiz\question\TextQuestion;

class Dataloader{
 
    public static function load(string $file): array{
        $file = file_get_contents($file);
        $data = json_decode($file);
        return $data;
    }
}