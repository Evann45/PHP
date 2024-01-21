<?php

declare(strict_types=1);

namespace Form;

require_once  "./InputRenderInterface.php";

abstract class Input implements Rendu {
    protected string $type;
    protected string $identifiant;
    protected string $nom;
    protected string $valeur = " ";
    protected string $etiquette;
    protected bool $obligatoire;

    public function __construct(string $type, string $identifiant, string $nom, string $valeur, string $etiquette, bool $obligatoire) {
        $this->type = $type;
        $this->identifiant = $identifiant;
        $this->nom = $nom;
        $this->valeur = $valeur;
        $this->etiquette = $etiquette;
        $this->obligatoire = $obligatoire;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getIdentifiant(): string {
        return $this->identifiant;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getValeur(): string {
        return $this->valeur;
    }

    public function getEtiquette(): string {
        return $this->etiquette;
    }

    public function estObligatoire(): string {
        return $this->obligatoire ? "required" : " ";
    }

    public abstract function rendu();
}

?>
