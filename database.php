<?php
$file_db = new PDO('sqlite:contacts.sqlite3');
$file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
?>