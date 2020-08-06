<?php

namespace PaymentBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PaymentBundle\Entity\Product;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $author1 = $manager->getRepository("UserBundle:User")->findOneByEmail("president@adresse.fr");
        $author2 = $manager->getRepository("UserBundle:User")->findOneByEmail("editeur@adresse.fr");

        $produit1 = new Product();
        $produit1->setTitle('Cotisation');
        $produit1->setDescription('Utque proeliorum periti rectores primo catervas densas opponunt et fortes, deinde leves armaturas, post iaculatores ultimasque subsidiales acies, si fors adegerit, iuvaturas, ita praepositis urbanae familiae');
        $produit1->setPrice(15);
        $produit1->setAuthor($author1);
        $produit1->setEnabled(1);
        $manager->persist($produit1);

        $produit2 = new Product();
        $produit2->setTitle('Homines');
        $produit2->setDescription('Proinde die funestis interrogationibus praestituto imaginarius iudex equitum resedit magister adhibitis aliis iam quae essent agenda praedoctis, et adsistebant hinc inde notarii, quid quaesitum esset, quidve responsum, cursim ad Caesarem perferentes, cuius imperio truci, stimulis reginae exsertantis aurem subinde per aulaeum, nec diluere obiecta permissi nec defensi periere conplures.');
        $produit2->setPrice(20);
        $produit2->setAuthor($author2);
        $produit2->setEnabled(1);
        $manager->persist($produit2);

        $produit3 = new Product();
        $produit3->setTitle('Quemquam');
        $produit3->setDescription('Eius populus ab incunabulis primis ad usque pueritiae tempus extremum, quod annis circumcluditur fere trecentis, circummurana pertulit bella, deinde aetatem ingressus adultam post multiplices bellorum aerumnas Alpes transcendit et fretum, in iuvenem erectus et virum ex omni plaga quam orbis ambit inmensus, reportavit laureas et triumphos, iamque vergens in senium et nomine solo aliquotiens vincens ad tranquilliora vitae discessit.');
        $produit3->setPrice(4);
        $produit3->setAuthor($author1);
        $produit3->setEnabled(1);
        $manager->persist($produit3);

        $produit4 = new Product();
        $produit4->setTitle('Benevolentiae');
        $produit4->setDescription('Cumque pertinacius ut legum gnarus accusatorem flagitaret atque sollemnia, doctus id Caesar libertatemque superbiam ratus tamquam obtrectatorem audacem excarnificari praecepit, qui ita evisceratus ut cruciatibus membra deessent, inplorans caelo iustitiam, torvum renidens fundato pectore mansit inmobilis nec se incusare nec quemquam alium passus et tandem nec confessus nec confutatus cum abiecto consorte poenali est morte multatus. et ducebatur intrepidus temporum iniquitati insultans, imitatus Zenonem illum veterem Stoicum qui ut mentiretur quaedam laceratus diutius, avulsam sedibus linguam suam cum cruento sputamine in oculos interrogantis Cyprii regis inpegit');
        $produit4->setPrice(3);
        $produit4->setAuthor($author2);
        $produit4->setEnabled(1);
        $manager->persist($produit4);

        $manager->flush();
    }

    public function getOrder()
    {
        return 7;
    }
}
