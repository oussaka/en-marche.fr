<?php


namespace AppBundle\ElectedRepresentativesRegister;


use AppBundle\Entity\Adherent;
use AppBundle\Entity\ElectedRepresentativesRegister;
use Doctrine\ORM\EntityManagerInterface;

class ElectedRepresentativesRegisterLoader
{
    private const BATCH_SIZE = 20;

    private const PROPERTIES = [
        'department_id',
        'commune_id',
        'adherent',
        'type_elu',
        'dpt',
        'dpt_nom',
        'nom',
        'prenom',
        'genre',
        'date_naissance',
        'code_profession',
        'nom_profession',
        'date_debut_mandat',
        'nom_fonction',
        'date_debut_fonction',
        'nuance_politique',
        'identification_elu',
        'nationalite_elu',
        'epci_siren',
        'epci_nom',
        'commune_dpt',
        'commune_code',
        'commune_nom',
        'commune_population',
        'canton_code',
        'canton_nom',
        'region_code',
        'region_nom',
        'euro_code',
        'euro_nom',
        'circo_legis_code',
        'circo_legis_nom',
        'infos_supp',
        'uuid',
        'nb_participation_events',
        'adherent_uuid',
    ];
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function load(string $filename): void
    {
        $repository = $this->manager->getRepository(Adherent::class);
        if (file_exists($filename)) {
            $file = file($filename);


            // TODO utiliser fgetcsv
            // TODO place dans la commande pour avoir la barre de progression + -vvvv pour avoir la consomation mémoire.
            $header = $this->getHeader($file[0]);

            unset($file[0]);

            foreach ($file as $index => $row) {

                if(empty(trim($row))) {
                    continue;
                }

                $row = $this->decodeRow($header, $row);
                $electedRepresentativesRegister = $this->denormalize($row);
                $electedRepresentativesRegister->setAdherent(
                    $repository->findOneBy([
                        'firstName' => $electedRepresentativesRegister->getPrenom(),
                        'lastName' => $electedRepresentativesRegister->getNom(),
                        'birthdate' => $electedRepresentativesRegister->getDateNaissance()
                    ])
                );
                $this->manager->persist($electedRepresentativesRegister);
                if(($index % self::BATCH_SIZE) === 0) {
                    $this->manager->flush();
                    $this->manager->clear();
                }
                unset($file[$index]);
            }
            $this->manager->flush();
            $this->manager->clear();
        }
    }

    private function getHeader(string $row): array
    {
        $header = explode(';', trim($row));
        foreach ($header as $index => $property) {
            if (!\in_array($property, self::PROPERTIES, true)) {
                throw new \Exception("property $property could not be set");
            }
            $property = str_replace(' ', '', ucwords(str_replace('_', ' ', $property)));
            $property[0] = strtolower($property[0]);
            $header[$index] = $property;
        }
        return $header;
    }

    private function decodeRow(array $keys, string $row): array
    {
        return array_combine($keys, explode(';', trim($row)));
    }

    private function denormalize(array $data): ElectedRepresentativesRegister
    {
        return ElectedRepresentativesRegister::createByModel(ElectedRepresentativesRegisterModel::createByArray($data));
    }

}
