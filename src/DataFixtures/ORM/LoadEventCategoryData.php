<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\BaseEventCategory;
use AppBundle\Entity\EventCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadEventCategoryData extends Fixture
{
    public const LEGACY_EVENT_CATEGORIES = [
        'event-category-1' => ['name' => 'Kiosque', 'status' => BaseEventCategory::ENABLED, 'group' => null],
        'event-category-2' => ['name' => 'Réunion d\'équipe', 'status' => BaseEventCategory::ENABLED, 'group' => null],
        'event-category-3' => ['name' => 'Conférence-débat', 'status' => BaseEventCategory::ENABLED, 'group' => null],
        'event-category-4' => ['name' => 'Porte-à-porte', 'status' => BaseEventCategory::ENABLED, 'group' => null],
        'event-category-5' => ['name' => 'Atelier du programme', 'status' => BaseEventCategory::ENABLED, 'group' => null],
        'event-category-6' => ['name' => 'Tractage', 'status' => BaseEventCategory::ENABLED, 'group' => null],
        'event-category-7' => ['name' => 'Convivialité', 'status' => BaseEventCategory::ENABLED, 'group' => null],
        'event-category-8' => ['name' => 'Action ciblée', 'status' => BaseEventCategory::ENABLED, 'group' => null],
        'event-category-9' => ['name' => 'Événement innovant', 'status' => BaseEventCategory::ENABLED, 'group' => null],
        'event-category-10' => ['name' => 'Marche', 'status' => BaseEventCategory::ENABLED, 'group' => null],
        'event-category-11' => ['name' => 'Support party', 'status' => BaseEventCategory::ENABLED, 'group' => null],
        'event-category-12' => ['name' => 'ancrage local', 'status' => BaseEventCategory::ENABLED, 'group' => 'event-group-category-1'],
        'event-category-13' => ['name' => 'projets citoyens', 'status' => BaseEventCategory::ENABLED, 'group' => 'event-group-category-1'],
        'event-category-14' => ['name' => 'Un An', 'status' => BaseEventCategory::ENABLED, 'group' => 'event-group-category-1'],
        'event-category-15' => ['name' => 'Débat', 'status' => BaseEventCategory::ENABLED, 'group' => 'event-group-category-2'],
        'event-category-16' => ['name' => 'Catégorie masquée', 'status' => BaseEventCategory::DISABLED, 'group' => null],
        ];

    public function load(ObjectManager $manager)
    {
        foreach (self::LEGACY_EVENT_CATEGORIES as $reference => $dataCategory) {
            $category = new EventCategory($dataCategory['name'], $dataCategory['status']);
            if ($dataCategory['group']) {
                $category->setEventGroupCategory($this->getReference($dataCategory['group']));
            }
            $this->addReference($reference, $category);
            $manager->persist($category);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LoadEventGroupCategoryData::class,
        ];
    }
}
