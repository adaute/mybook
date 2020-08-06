<?php

namespace UserBundle\DataFixtures\ORM;

use UserBundle\Entity\Rank;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadRank extends AbstractFixture implements OrderedFixtureInterface
{
    /** @var ContainerInterface */
    private $container;

    public function load(ObjectManager $manager)
    {
        $this->loadRank($manager);
    }

    private function loadRank(ObjectManager $manager)
    {
        $rank1 = new Rank();
        $rank1->setTitle("Président");
        $rank1->setPosition(1);
        $rank1->setEnabled(1);
        $manager->persist($rank1);

        $rank2 = new Rank();
        $rank2->setTitle("Vice Président");
        $rank2->setPosition(2);
        $rank2->setEnabled(1);
        $manager->persist($rank2);

        $rank3 = new Rank();
        $rank3->setTitle("Secrétaire");
        $rank3->setPosition(3);
        $rank3->setEnabled(1);
        $manager->persist($rank3);

        $rank4 = new Rank();
        $rank4->setTitle("trésorier");
        $rank4->setPosition(4);
        $rank4->setEnabled(1);
        $manager->persist($rank4);

        $rank5 = new Rank();
        $rank5->setTitle("Membre");
        $rank5->setPosition(5);
        $rank5->setEnabled(0);
        $manager->persist($rank5);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder()
    {
        return 1;
    }
}
