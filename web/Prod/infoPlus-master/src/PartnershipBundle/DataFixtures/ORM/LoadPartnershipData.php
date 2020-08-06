<?php

namespace PartnershipBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PartnershipBundle\Entity\Partnership;

class LoadPartnershipData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $picture1 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("cappadocia-805626_960_720.jpg");
        $picture2 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("luggage-1149289_960_720.jpg");
        $picture3 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("volkswagen-569315_960_720.jpg");
        $picture4 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("plane-1000996_960_720.jpg");

        $partnership1 = new Partnership();
        $partnership1->setName('Potestate');
        $partnership1->setDescription('Utque proeliorum periti rectores primo catervas densas opponunt et fortes, deinde leves armaturas, post iaculatores ultimasque subsidiales acies, si fors adegerit, iuvaturas, ita praepositis urbanae familiae');
        $partnership1->setAdress('1758 Sugarfoot Lane Waveland, IN 47989');
        $partnership1->setBadge('Or');
        $partnership1->setImage($picture1);
        $partnership1->setEnabled(1);
        $manager->persist($partnership1);

        $partnership2 = new Partnership();
        $partnership2->setName('Hominum');
        $partnership2->setDescription('Coactique aliquotiens nostri pedites ad eos persequendos scandere clivos sublimes etiam si lapsantibus plantis fruticeta prensando vel dumos ad vertices venerint summos, inter arta tamen et invia nullas acies explicare permissi nec firmare nisu valido gressus: hoste discursatore rupium abscisa volvente, ruinis ponderum inmanium consternuntur, aut ex necessitate ultima fortiter dimicante, superati periculose per prona discedunt.');
        $partnership2->setAdress('15 Kyle Street Heartwell, NE 68945');
        $partnership2->setBadge('Bronze');
        $partnership2->setImage($picture2);
        $partnership2->setEnabled(1);
        $manager->persist($partnership2);

        $partnership3 = new Partnership();
        $partnership3->setName('Multis');
        $partnership3->setDescription('Post hanc adclinis Libano monti Phoenice, regio plena gratiarum et venustatis, urbibus decorata magnis et pulchris; in quibus amoenitate celebritateque nominum Tyros excellit, Sidon et Berytus isdemque pares Emissa et Damascus saeculis condita priscis.');
        $partnership3->setAdress('2979 Glen Street Madisonville, KY 42431');
        $partnership3->setBadge('Argent');
        $partnership3->setImage($picture3);
        $partnership3->setEnabled(1);
        $manager->persist($partnership3);

        $partnership4 = new Partnership();
        $partnership4->setName('Caesar ');
        $partnership4->setDescription('Et quia Mesopotamiae tractus omnes crebro inquietari sueti praetenturis et stationibus servabantur agrariis, laevorsum flexo itinere Osdroenae subsederat extimas partes, novum parumque aliquando temptatum commentum adgressus. quod si impetrasset, fulminis modo cuncta vastarat. erat autem quod cogitabat huius modi.');
        $partnership4->setAdress('4157 Fancher Drive Dallas, TX 75204');
        $partnership4->setBadge('Or');
        $partnership4->setImage($picture4);
        $partnership4->setEnabled(0);
        $manager->persist($partnership4);

        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }
}
