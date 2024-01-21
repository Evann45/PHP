<?php

class AutoLoader {

    static function enregistrer() {
        spl_autoload_register(array(__CLASS__, "autoload"));
    }

    static function autoload($classe) {
        $chemin = str_replace("\\","/", $classe);
        return "Classes/".$chemin.".php";
    }

    function spl_autoload_register($classe) {
        $fichier = __DIR__ . '/' . str_replace('\\', '/', $classe) . '.php';
        if (file_exists($fichier)) {
            require $fichier;
        }
    }
}

?>
