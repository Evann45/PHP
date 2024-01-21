<?php

namespace Classes\Form\Type;

require_once __DIR__ . "/GeneriqueFormElement.php";

use \Form\Input;

class InputCheckbox extends Input {
    public function __construct($identifiant, $nom, $valeur, $etiquette, $obligatoire) {
        parent::__construct("checkbox", $identifiant, $nom, $valeur, $etiquette, $obligatoire);
    }

    public function rendu() {
        $etiquette = "<label for='" . $this->getEtiquette() . "'>" . $this->getValeur() . " : </label>";
        $input = "<input type='" . $this->getType() . "' name='" . $this->getNom() . "[]' id='". $this->getIdentifiant() . "' value='" . $this->getValeur() . "' </input>"; 
        return $etiquette . $input;
    }
}

?>
