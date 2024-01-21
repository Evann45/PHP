<?php

namespace Classes\Form\Type;

use Form\Input;

//require_once "../GeneriqueFormElement.php";
class InputNumber extends Input {
    public function __construct($identifiant, $nom, $valeur, $etiquette, $obligatoire) {
        parent::__construct("number", $identifiant, $nom, $valeur, $etiquette, $obligatoire);
    }

    public function rendu() {
        parent::rendu();
    }
}

?>
