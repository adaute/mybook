<?php

namespace InternshipBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InternshipBundle\Entity\Internship;

class LoadInternshipData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $intnership1 = new Internship();
        $intnership1->setTitle('Potestate');
        $intnership1->setDescription('Utque proeliorum periti rectores primo catervas densas opponunt et fortes, deinde leves armaturas, post iaculatores ultimasque subsidiales acies, si fors adegerit, iuvaturas, ita praepositis urbanae familiae');
        $intnership1->setSociety('Inminuta');
        $intnership1->setPhone('06XXXXXXX');
        $intnership1->setEmail('accedebant@monadresse.fr');
        $intnership1->setField('Cocibus');
        $intnership1->setDiploma('Rumores');
        $intnership1->setCreatedAt(\DateTime::createFromFormat('d/m/Y', '04/06/2016'));
        $intnership1->setEnabled(1);
        $manager->persist($intnership1);

        $intnership2 = new Internship();
        $intnership2->setTitle('Amabilius');
        $intnership2->setDescription('Nam quibusdam, quos audio sapientes habitos in Graecia, placuisse opinor mirabilia quaedam (sed nihil est quod illi non persequantur argutiis): partim fugiendas esse nimias amicitias, ne necesse sit unum sollicitum esse pro pluribus; satis superque esse sibi suarum cuique rerum, alienis nimis implicari molestum esse; commodissimum esse quam laxissimas habenas habere amicitiae, quas vel adducas, cum velis, vel remittas; caput enim esse ad beate vivendum securitatem, qua frui non possit animus, si tamquam parturiat unus pro pluribus.');
        $intnership2->setSociety('Metuitur');
        $intnership2->setPhone('06XXXXXXX');
        $intnership2->setEmail('timebantur@monadresse.fr');
        $intnership2->setField('Quibusdam');
        $intnership2->setDiploma('Pluribus');
        $intnership2->setCreatedAt(\DateTime::createFromFormat('d/m/Y', '02/03/2016'));
        $intnership2->setEnabled(1);
        $manager->persist($intnership2);

        $intnership3 = new Internship();
        $intnership3->setTitle('Insignem');
        $intnership3->setDescription('Saepissime igitur mihi de amicitia cogitanti maxime illud considerandum videri solet, utrum propter imbecillitatem atque inopiam desiderata sit amicitia, ut dandis recipiendisque meritis quod quisque minus per se ipse posset, id acciperet ab alio vicissimque redderet, an esset hoc quidem proprium amicitiae, sed antiquior et pulchrior et magis a natura ipsa profecta alia causa. Amor enim, ex quo amicitia nominata est, princeps est ad benevolentiam coniungendam. Nam utilitates quidem etiam ab iis percipiuntur saepe qui simulatione amicitiae coluntur et observantur temporis causa, in amicitia autem nihil fictum est, nihil simulatum et, quidquid est, id est verum et voluntarium.');
        $intnership3->setSociety('Aegrum');
        $intnership3->setPhone('06XXXXXXX');
        $intnership3->setEmail('igitur@monadresse.fr');
        $intnership3->setField('Prima');
        $intnership3->setDiploma('Postulabit');
        $intnership3->setCreatedAt(\DateTime::createFromFormat('d/m/Y', '01/05/2016'));
        $intnership3->setEnabled(1);
        $manager->persist($intnership3);

        $intnership4 = new Internship();
        $intnership4->setTitle('Huius');
        $intnership4->setDescription('Dumque ibi diu moratur commeatus opperiens, quorum translationem ex Aquitania verni imbres solito crebriores prohibebant auctique torrentes, Herculanus advenit protector domesticus, Hermogenis ex magistro equitum filius, apud Constantinopolim, ut supra rettulimus, populari quondam turbela discerpti. quo verissime referente quae Gallus egerat, damnis super praeteritis maerens et futurorum timore suspensus angorem animi quam diu potuit emendabat.');
        $intnership4->setSociety('Siquis');
        $intnership4->setPhone('06XXXXXXX');
        $intnership4->setEmail('coactusque@monadresse.fr');
        $intnership4->setField('Cocibus');
        $intnership4->setDiploma('Porrecta');
        $intnership4->setCreatedAt(\DateTime::createFromFormat('d/m/Y', '08/04/2016'));
        $intnership4->setEnabled(0);
        $manager->persist($intnership4);

        $manager->flush();
        
    }

    public function getOrder()
    {
        return 11;
    }
}
