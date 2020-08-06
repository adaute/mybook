<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $cat1 = new Category();
        $cat1->setTitle('Quorundam');
        $manager->persist($cat1);

        $cat2 = new Category();
        $cat2->setTitle('Refertissimam');
        $manager->persist($cat2);

        $cat3 = new Category();
        $cat3->setTitle('Armatum');
        $manager->persist($cat3);

        $cat4 = new Category();
        $cat4->setTitle('Reliqua');
        $manager->persist($cat4);

        $cat5 = new Category();
        $cat5->setTitle('Tenuerunt');
        $manager->persist($cat5);

        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}
