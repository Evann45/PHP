<?php

namespace Classes\Form\Type;

use Form\Input;

//require_once "../GeneriqueFormElement.php";
class InputHidden extends Input {
    public function __construct($identifiant, $nom, $valeur, $etiquette, $obligatoire) {
        parent::__construct("hidden", $identifiant, $nom, $valeur, $etiquette, $obligatoire);
    }

    public function rendu() {
        parent::rendu();
    }
}

?>
