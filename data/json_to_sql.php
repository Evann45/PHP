<?php

try {

    if (file_exists('bd.sqlite3')) {
        unlink('bd.sqlite3');
    }

    $db = new PDO('sqlite:bd.sqlite3');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("CREATE TABLE IF NOT EXISTS questions (
    id TEXT PRIMARY KEY, 
    question TEXT, 
    typereponse TEXT,
    bonnereponse TEXT 
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS reponse (
        id INTEGER PRIMARY KEY,
        question_id TEXT,
        reponse TEXT,
        FOREIGN KEY (question_id) REFERENCES questions(id)
    )");

    

    $json = file_get_contents('data/model.json');
    $json_data = json_decode($json, true);

    for ($i = 0; $i < count($json_data); $i++) {

        $id = $json_data[$i]['uuid'];
        $question = $json_data[$i]['label'];
        $typereponse = $json_data[$i]['type'];
        $bonnereponse = $json_data[$i]['correct'];

        $stmt = $db->prepare("INSERT INTO questions (id,question, typereponse, bonnereponse) VALUES (:id,:question, :typereponse, :bonnereponse)");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':question', $question);
        $stmt->bindParam(':typereponse', $typereponse);
        $stmt->bindParam(':bonnereponse', $bonnereponse);
        $stmt->execute();

       

        if(isset($json_data[$i]["choices"])){

            $reponses = $json_data[$i]["choices"];
            for ($j = 0; $j < count($reponses); $j++) {
                $reponse = $reponses[$j];
                $stmt = $db->prepare("INSERT INTO reponse (question_id, reponse) VALUES (:question_id, :reponse)");
                $stmt->bindParam(':question_id', $id);
                $stmt->bindParam(':reponse', $reponse);
                $stmt->execute();
            }
        }
    }

} catch (PDOException $e) {
    echo $e->getMessage().PHP_EOL;
}