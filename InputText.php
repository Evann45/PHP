<?php

namespace Classes\Form\Type;

require_once __DIR__ . "/GeneriqueFormElement.php";

use Form\Input;

class InputText extends Input {
    public function __construct($identifiant, $nom, $valeur, $etiquette, $obligatoire) {
        parent::__construct("text", $identifiant, $nom, $valeur, $etiquette, $obligatoire);
    }

    public function rendu() {
        $input = "<input type='" . $this->getType() . "' name='" . $this->getEtiquette() . "' id='" . $this->getIdentifiant() . "' </input>"; 
        return $input;
    }
}

?>
