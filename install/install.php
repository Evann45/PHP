<?php 

$file = file_get_contents("../data/model.json");
$data = json_decode($file);

$db = new PDO("sqlite:database.sqlite3");
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

$db = null;
