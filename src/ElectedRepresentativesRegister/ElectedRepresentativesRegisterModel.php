<?php


namespace AppBundle\ElectedRepresentativesRegister;


class ElectedRepresentativesRegisterModel
{
    public $departmentId;

    public $communeId;

    public $adherent;

    public $typeElu;

    public $dpt;

    public $dptNom;

    public $nom;

    public $prenom;

    public $genre;

    public $dateNaissance;

    public $codeProfession;

    public $nomProfession;

    public $dateDebutMandat;

    public $nomFonction;

    public $dateDebutFonction;

    public $nuancePolitique;

    public $identificationElu;

    public $nationaliteElu;

    public $epciSiren;

    public $epciNom;

    public $communeDpt;

    public $communeCode;

    public $communeNom;

    public $communePopulation;

    public $cantonCode;

    public $cantonNom;

    public $regionCode;

    public $regionNom;

    public $euroCode;

    public $euroNom;

    public $circoLegisCode;

    public $circoLegisNom;

    public $infosSupp;

    public $uuid;

    public $nbParticipationEvents;

    public $adherentUuid;

    public static function createByArray(array $data): self {
        $model = new self();
        foreach ($data as $property => $value) {
            $model->$property = empty($value) ? null : $value;
        }
        return $model;
    }

}
