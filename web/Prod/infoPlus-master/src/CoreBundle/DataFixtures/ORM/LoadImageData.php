<?php

namespace CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CoreBundle\Entity\image;

class LoadImageData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // images pour topic
        $picture1 = new Image();
        $picture1->setExtension("jpeg");
        $picture1->setAlt("road-2199357_1280.jpg");
        $manager->persist($picture1);

        $picture2 = new Image();
        $picture2->setExtension("jpeg");
        $picture2->setAlt("fox-1540833_1280.jpg");
        $manager->persist($picture2);

        $picture3 = new Image();
        $picture3->setExtension("jpeg");
        $picture3->setAlt("landscape-2090495_1920.jpg");
        $manager->persist($picture3);

        $picture4 = new Image();
        $picture4->setExtension("jpeg");
        $picture4->setAlt("garda-202065_1280.jpg");
        $manager->persist($picture4);

        $picture5 = new Image();
        $picture5->setExtension("jpeg");
        $picture5->setAlt("mountain-1504197_1280.jpg");
        $manager->persist($picture5);

        $picture6 = new Image();
        $picture6->setExtension("jpeg");
        $picture6->setAlt("horsesdhoe-bend-1908283_1280.jpg");
        $manager->persist($picture6);

        // images pour users
        $picture7 = new Image();
        $picture7->setExtension("jpeg");
        $picture7->setAlt("president.jpg");
        $manager->persist($picture7);

        $picture8 = new Image();
        $picture8->setExtension("jpeg");
        $picture8->setAlt("secretaire.jpg");
        $manager->persist($picture8);

        $picture9 = new Image();
        $picture9->setExtension("jpeg");
        $picture9->setAlt("tresorier.jpg");
        $manager->persist($picture9);

        $picture10 = new Image();
        $picture10->setExtension("jpeg");
        $picture10->setAlt("membre.jpg");
        $manager->persist($picture10);

        // image pour diary
        $picture11 = new Image();
        $picture11->setExtension("jpeg");
        $picture11->setAlt("cappadocia-805626_960_720.jpg");
        $manager->persist($picture11);

        $picture12 = new Image();
        $picture12->setExtension("jpeg");
        $picture12->setAlt("luggage-1149289_960_720.jpg");
        $manager->persist($picture12);

        $picture13 = new Image();
        $picture13->setExtension("jpeg");
        $picture13->setAlt("volkswagen-569315_960_720.jpg");
        $manager->persist($picture13);

        $picture14 = new Image();
        $picture14->setExtension("jpeg");
        $picture14->setAlt("plane-1000996_960_720.jpg");
        $manager->persist($picture14);

        $manager->flush();
        
    }

    public function getOrder()
    {
        return 1;
    }
}
