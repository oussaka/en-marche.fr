<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ElectedRepresentativesRegister;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadElectedRepresentativesRegisterData extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $elus = [
            [1,1,'adherent-1', 'conseiller_municipal','01','AIN','DUFOUR','Michelle','female','1972-11-23',10,'Artisans','2014-03-23',NULL,NULL,'NC',1203084,'Française',NULL,NULL,NULL,1,'L\'Abergement-Clémenciat',780,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'698be483b9bee9dc1eb72ff40cd18067',NULL,NULL],
            [1,1,NULL,'conseiller_municipal','01','AIN','BOUILLOUX','Delphine','female','1977-08-02',2,'Salariés agricoles','2014-03-23',NULL,NULL,'NC',1203080,'Française',NULL,NULL,NULL,1,'L\'Abergement-Clémenciat',780,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'967d13cb5074d0752a39b39b3078f83a',NULL,NULL],
            [1,1,NULL,'conseiller_municipal','01','AIN','BOULON','Daniel','male','1951-03-04',61,'Retraités salariés privés','2014-03-23','Maire','2014-03-23','DIV',694516,'Française',NULL,NULL,NULL,1,'L\'Abergement-Clémenciat',780,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'879a745996db861ed36af1016b74d063',NULL,NULL],
            [1,1,NULL,'conseiller_municipal','01','AIN','BUET','Roger','male','1952-04-21',1,'Agriculteurs propriétaires exploit.','2014-03-23','Troisième adjoint au maire','2014-03-23','DIV',873399,'Française',NULL,NULL,NULL,1,'L\'Abergement-Clémenciat',780,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'3fe0efa5ce50c6eb76a804cffa536b61',NULL,NULL],
            [1,1,NULL,'conseiller_municipal','01','AIN','LLOBELL','André','male','1951-11-03',62,'Retraités de l\'enseignement','2014-03-23','Second adjoint au maire','2014-03-23','DIV',873404,'Française',NULL,NULL,NULL,1,'L\'Abergement-Clémenciat',780,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'73ea9b609b9e10db8acf74a0ba3b7811',NULL,NULL],
        ];

        foreach ($elus as $elu) {
            $register = ElectedRepresentativesRegister::create(
                $elu[0],
                $elu[1],
                $elu[2] !== null ? $this->getReference($elu[2]) : null,
                $elu[3],
                $elu[4],
                $elu[5],
                $elu[6],
                $elu[7],
                $elu[8],
                new \DateTime($elu[9]),
                $elu[10],
                $elu[11],
                $elu[12],
                $elu[13],
                new \DateTime($elu[14]),
                $elu[15],
                $elu[16],
                $elu[17],
                $elu[18],
                $elu[19],
                $elu[20],
                $elu[21],
                $elu[22],
                $elu[23],
                $elu[24],
                $elu[25],
                $elu[26],
                $elu[27],
                $elu[28],
                $elu[29],
                $elu[30],
                $elu[31],
                $elu[32],
                $elu[33],
                $elu[34],
                $elu[35]
            );
            $manager->persist($register);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LoadAdherentData::class
        ];
    }
}
