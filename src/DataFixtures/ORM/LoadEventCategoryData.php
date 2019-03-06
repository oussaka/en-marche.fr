<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\EventCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadEventCategoryData extends Fixture
{
    public const LEGACY_EVENT_CATEGORIES = [
        'CE001' => 'Kiosque',
        'CE002' => 'Réunion d\'équipe',
        'CE003' => 'Conférence-débat',
        'CE004' => 'Porte-à-porte',
        'CE005' => 'Atelier du programme',
        'CE006' => 'Tractage',
        'CE007' => 'Convivialité',
        'CE008' => 'Action ciblée',
        'CE009' => 'Événement innovant',
        'CE010' => 'Marche',
        'CE011' => 'Support party',
    ];

    public const EVENT_CATEGORIES_GROUPED = [
        'ancrage local' => 'event-group-category-1',
        'projets citoyens' => 'event-group-category-1',
        'Un An' => 'event-group-category-1',
        'Débat' => 'event-group-category-2',
    ];

    public const HIDDEN_CATEGORY_NAME = 'Catégorie masquée';

    public function load(ObjectManager $manager)
    {
        foreach (self::LEGACY_EVENT_CATEGORIES as $name) {
            $manager->persist(new EventCategory($name));
        }

        foreach (self::EVENT_CATEGORIES_GROUPED as $name => $group) {
            $eventCategory = new EventCategory($name);
            $eventCategory->setEventGroupCategory($this->getReference($group));
            $manager->persist($eventCategory);
        }

        $manager->persist(new EventCategory(self::HIDDEN_CATEGORY_NAME, EventCategory::DISABLED));

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LoadEventGroupCategoryData::class,
        ];
    }
}
