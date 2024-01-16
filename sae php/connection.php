<?php
$dsn="mysql:dbname="."DBmartins".";host="."servinfo-mariadb";
    try{
      $connexion=new PDO($dsn,"martins","martins");
      $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    catch(PDOException $e){
      printf("Échec de la connexion : %s\n", $e->getMessage());
      exit();
    }
    // $stmt = $connexion->query("SELECT * FROM poney");
    // $user = $stmt->fetch();
    // while ($row = $stmt->fetch()) {
    //     echo "<p>" .$row['nomP']."</p>\n";
    // }
?>