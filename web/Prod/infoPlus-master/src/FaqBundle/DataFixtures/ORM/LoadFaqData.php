<?php

namespace FaqBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FaqBundle\Entity\Faq;

class LoadFaqData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $category1 = $manager->getRepository("AppBundle:Category")->findOneByTitle('Quorundam');
        $category2 = $manager->getRepository("AppBundle:Category")->findOneByTitle('Refertissimam');
        $category3 = $manager->getRepository("AppBundle:Category")->findOneByTitle('Armatum');
        $category4 = $manager->getRepository("AppBundle:Category")->findOneByTitle('Reliqua');
        $category5 = $manager->getRepository("AppBundle:Category")->findOneByTitle('Tenuerunt');

        $faq1 = new Faq();
        $faq1->setAsk('Intellectum est enim mihi quidem in multis ?');
        $faq1->setAnswer('Sed laeditur hic coetuum magnificus splendor levitate paucorum incondita, ubi nati sunt non reputantium, sed tamquam indulta licentia vitiis ad errores lapsorum ac lasciviam. ut enim Simonides lyricus docet, beate perfecta ratione vieturo ante alia patriam esse convenit gloriosam.');
        $faq1->setAskEn('Ex his quidam aeternitati se commendari posse ?');
        $faq1->setAnswerEn('Omitto iuris dictionem in libera civitate contra leges senatusque consulta; caedes relinquo; libidines praetereo, quarum acerbissimum extat indicium et ad insignem memoriam turpitudinis et paene ad iustum odium imperii nostri, quod constat nobilissimas virgines se in puteos abiecisse et morte voluntaria necessariam turpitudinem depulisse. Nec haec idcirco omitto, quod non gravissima sint, sed quia nunc sine teste dico.');
        $faq1->setCategory($category1);
        $manager->persist($faq1);

        $faq2 = new Faq();
        $faq2->setAsk('Ex his quidam aeternitati se commendari posse ?');
        $faq2->setAnswer('Omitto iuris dictionem in libera civitate contra leges senatusque consulta; caedes relinquo; libidines praetereo, quarum acerbissimum extat indicium et ad insignem memoriam turpitudinis et paene ad iustum odium imperii nostri, quod constat nobilissimas virgines se in puteos abiecisse et morte voluntaria necessariam turpitudinem depulisse. Nec haec idcirco omitto, quod non gravissima sint, sed quia nunc sine teste dico.');
        $faq2->setAskEn('Intellectum est enim mihi quidem in multis ?');
        $faq2->setAnswerEn('Sed laeditur hic coetuum magnificus splendor levitate paucorum incondita, ubi nati sunt non reputantium, sed tamquam indulta licentia vitiis ad errores lapsorum ac lasciviam. ut enim Simonides lyricus docet, beate perfecta ratione vieturo ante alia patriam esse convenit gloriosam.');
        $faq2->setCategory($category1);
        $manager->persist($faq2);

        $faq3 = new Faq();
        $faq3->setAsk('Equitis Romani autem esse filium ?');
        $faq3->setAnswer('Post quorum necem nihilo lenius ferociens Gallus ut leo cadaveribus pastus multa huius modi scrutabatur. quae singula narrare non refert, me professione modum, quod evitandum est, excedamus.');
        $faq3->setCategory($category2);
        $manager->persist($faq3);

        $faq4 = new Faq();
        $faq4->setAsk('Unde Rufinus ea tempestate praefectus praetorio ?');
        $faq4->setAnswer('Principium autem unde latius se funditabat, emersit ex negotio tali. Chilo ex vicario et coniux eius Maxima nomine, questi apud Olybrium ea tempestate urbi praefectum, vitamque suam venenis petitam adseverantes inpetrarunt ut hi, quos suspectati sunt, ilico rapti conpingerentur in vincula, organarius Sericus et Asbolius palaestrita et aruspex Campensis.');
        $faq4->setCategory($category3);
        $manager->persist($faq4);

        $faq5 = new Faq();
        $faq5->setAsk('Et hanc quidem praeter oppida multa ?');
        $faq5->setAnswer('Denique Antiochensis ordinis vertices sub uno elogio iussit occidi ideo efferatus, quod ei celebrari vilitatem intempestivam urgenti, cum inpenderet inopia, gravius rationabili responderunt; et perissent ad unum ni comes orientis tunc Honoratus fixa constantia restitisset.');
        $faq5->setCategory($category4);
        $manager->persist($faq5);

        $faq6 = new Faq();
        $faq6->setAsk('Latius iam disseminata licentia onerosus ?');
        $faq6->setAnswer('Nec vox accusatoris ulla licet subditicii in his malorum quaerebatur');
        $faq6->setCategory($category5);
        $manager->persist($faq6);

        $manager->flush();
    }

    public function getOrder()
    {
        return 6;
    }
}
