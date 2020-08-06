<?php

namespace TicketBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TicketBundle\Entity\Ticket;

class LoadTicketData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $category1 = $manager->getRepository("AppBundle:Category")->findOneByTitle('Quorundam');
        $category2 = $manager->getRepository("AppBundle:Category")->findOneByTitle('Refertissimam');
        $category3 = $manager->getRepository("AppBundle:Category")->findOneByTitle('Armatum');

        $ticket1 = new Ticket();
        $ticket1->setFirstName("Sine");
        $ticket1->setLastName("Respectu");
        $ticket1->setCellphone("078X678909");
        $ticket1->setEmail("ferrum@monadresse.fr");
        $ticket1->setCategory($category1);
        $ticket1->setSubject("Proinde concepta rabie saeviore");
        $ticket1->setAdditionnalInformation("Abusus enim multitudine hominum, quam tranquillis in rebus diutius rexit, ex agrestibus habitaculis urbes construxit multis opibus firmas et viribus, quarum ad praesens pleraeque licet Graecis nominibus appellentur, quae isdem ad arbitrium inposita sunt conditoris.");
        $ticket1->setToken("jCXF3fqM2dVHbB8OwEl9Qk6RkATQmwHCQt-9ws-Qppg");
        $ticket1->setPublishedAt(\DateTime::createFromFormat('d/m/Y', '04/06/2016'));
        $ticket1->setUpdatedAt(\DateTime::createFromFormat('d/m/Y', '18/06/2016'));
        $ticket1->setEnabled(1);
        $manager->persist($ticket1);

        $ticket2 = new Ticket();
        $ticket2->setFirstName("Dum");
        $ticket2->setLastName("Haerebis");
        $ticket2->setCellphone("078067X908");
        $ticket2->setEmail("indicatum@monadresse.fr");
        $ticket2->setCategory($category2);
        $ticket2->setSubject("Nemo quaeso miretur");
        $ticket2->setAdditionnalInformation("Qui cum venisset ob haec festinatis itineribus Antiochiam, praestrictis palatii ianuis, contempto Caesare, quem videri decuerat, ad praetorium cum pompa sollemni perrexit morbosque diu causatus nec regiam introiit nec processit in publicum, sed abditus .");
        $ticket2->setToken("jCXF3fqM2dVHbB8OwEl9Qk6RkATQewHCQt-9ws-Qppg");
        $ticket2->setPublishedAt(\DateTime::createFromFormat('d/m/Y', '14/06/2016'));
        $ticket2->setUpdatedAt(\DateTime::createFromFormat('d/m/Y', '20/06/2016'));
        $ticket2->setEnabled(0);
        $ticket2->setArchived(1);
        $ticket2->setArchiveAt(\DateTime::createFromFormat('d/m/Y', '28/06/2016'));
        $manager->persist($ticket2);

        $ticket3 = new Ticket();
        $ticket3->setFirstName("Tyrum");
        $ticket3->setLastName("Quam");
        $ticket3->setCellphone("0X89678900");
        $ticket3->setEmail("hesterno@monadresse.fr");
        $ticket3->setCategory($category3);
        $ticket3->setSubject("Sed maximum est in amicitia");
        $ticket3->setAdditionnalInformation("Per hoc minui studium suum existimans Paulus, ut erat in conplicandis negotiis artifex dirus, unde ei Catenae inditum est cognomentum, vicarium ipsum eos quibus praeerat adhuc defensantem ad sortem periculorum communium traxit. et instabat ut eum quoque cum tribunis.");
        $ticket3->setToken("jCXF3fqM2dVHbB8OwEl9Qk6RzATQmwHCQt-9ws-Qppg");
        $ticket3->setPublishedAt(\DateTime::createFromFormat('d/m/Y', '24/06/2016'));
        $ticket3->setUpdatedAt(\DateTime::createFromFormat('d/m/Y', '01/06/2016'));
        $ticket3->setEnabled(1);
        $manager->persist($ticket3);

        $manager->flush();
    }

    public function getOrder()
    {
        return 8;
    }
}
