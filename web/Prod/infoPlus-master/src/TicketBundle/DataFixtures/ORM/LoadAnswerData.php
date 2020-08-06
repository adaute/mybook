<?php

namespace TicketBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TicketBundle\Entity\Answer;

class LoadAnswerData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user1 = $manager->getRepository("UserBundle:User")->findOneBy(array('username' => 'admin'));

        $ticket1 = $manager->getRepository("TicketBundle:Ticket")->findOneBy(array('Token' => 'jCXF3fqM2dVHbB8OwEl9Qk6RkATQmwHCQt-9ws-Qppg'));
        $ticket2 = $manager->getRepository("TicketBundle:Ticket")->findOneBy(array('Token' => 'jCXF3fqM2dVHbB8OwEl9Qk6RkATQewHCQt-9ws-Qppg'));

        $answer1 = new Answer();
        $answer1->setTicket($ticket1);
        $answer1->setAnswer("Restabat ut Caesar post haec properaret accitus et abstergendae causa suspicionis sororem suam, eius uxorem, Constantius ad se tandem desideratam venire multis fictisque blanditiis hortabatur. quae licet ambigeret metuens saepe cruentum, spe tamen quod eum lenire poterit ut germanum profecta, cum Bithyniam introisset, in statione quae Caenos Gallicanos appellatur, absumpta est vi febrium repentina. cuius post obitum maritus contemplans cecidisse fiduciam qua se fultum existimabat, anxia cogitatione, quid moliretur haerebat.");
        $answer1->setAuthor($user1);
        $answer1->setCreatedAt(\DateTime::createFromFormat('d/m/Y', '10/05/2017'));
        $manager->persist($answer1);

        $answer2 = new Answer();
        $answer2->setTicket($ticket1);
        $answer2->setAnswer("Haec et huius modi quaedam innumerabilia ultrix facinorum impiorum bonorumque praemiatrix aliquotiens operatur Adrastia atque utinam semper quam vocabulo duplici etiam Nemesim appellamus: ius quoddam sublime numinis efficacis, humanarum mentium opinione lunari circulo superpositum, vel ut definiunt alii, substantialis tutela generali potentia partilibus praesidens fatis, quam theologi veteres fingentes Iustitiae filiam ex abdita quadam aeternitate tradunt omnia despectare terrena.");
        $answer2->setCreatedAt(\DateTime::createFromFormat('d/m/Y', '12/05/2017'));
        $manager->persist($answer2);

        $answer3 = new Answer();
        $answer3->setTicket($ticket2);
        $answer3->setAnswer("Ut enim quisque sibi plurimum confidit et ut quisque maxime virtute et sapientia sic munitus est, ut nullo egeat suaque omnia in se ipso posita iudicet, ita in amicitiis expetendis colendisque maxime excellit. Quid enim? Africanus indigens mei? Minime hercule! ac ne ego quidem illius; sed ego admiratione quadam virtutis eius, ille vicissim opinione fortasse non nulla, quam de meis moribus habebat, me dilexit; auxit benevolentiam consuetudo. Sed quamquam utilitates multae et magnae consecutae sunt, non sunt tamen ab earum spe causae diligendi profectae.");
        $answer3->setAuthor($user1);
        $answer3->setCreatedAt(\DateTime::createFromFormat('d/m/Y', '10/05/2017'));
        $manager->persist($answer3);

        $answer4 = new Answer();
        $answer4->setTicket($ticket2);
        $answer4->setAnswer("Sed quid est quod in hac causa maxime homines admirentur et reprehendant meum consilium, cum ego idem antea multa decreverim, que magis ad hominis dignitatem quam ad rei publicae necessitatem pertinerent? Supplicationem quindecim dierum decrevi sententia mea. Rei publicae satis erat tot dierum quot C. Mario ; dis immortalibus non erat exigua eadem gratulatio quae ex maximis bellis. Ergo ille cumulus dierum hominis est dignitati tributus.");
        $answer4->setCreatedAt(\DateTime::createFromFormat('d/m/Y', '12/05/2017'));
        $manager->persist($answer4);

        $manager->flush();
    }

    public function getOrder()
    {
        return 9;
    }
}
