<?php

namespace DiaryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DiaryBundle\Entity\Diary;
use PaymentBundle\Entity\Product;

class LoadDiaryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $author1 = $manager->getRepository("UserBundle:User")->findOneByEmail("editeur@adresse.fr");

        $picture1 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("cappadocia-805626_960_720.jpg");
        $picture2 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("luggage-1149289_960_720.jpg");
        $picture3 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("volkswagen-569315_960_720.jpg");
        $picture4 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("plane-1000996_960_720.jpg");

        $produit1 = new Product();
        $produit1->setTitle('Praediximus');
        $produit1->setDescription('Utque proeliorum periti rectores primo catervas densas opponunt et fortes, deinde leves armaturas, post iaculatores ultimasque subsidiales acies, si fors adegerit, iuvaturas, ita praepositis urbanae familiae');
        $produit1->setPrice(10);
        $produit1->setEnabled(1);
        $produit1->setAuthor($author1);
        $manager->persist($produit1);

        $diaryal1 = new Diary();
        $diaryal1->setDateDiary(\DateTime::createFromFormat('d/m/Y', '24/06/2017'));
        $diaryal1->setLieu("Eusebius");
        $diaryal1->setRemainingSpace(10);
        $diaryal1->setEnabled(1);
        $diaryal1->setVip(false);
        $diaryal1->setImage($picture1);
        $diaryal1->setProduct($produit1);
        $manager->persist($diaryal1);

        $produit2 = new Product();
        $produit2->setTitle('Indumentum');
        $produit2->setDescription('Paphius quin etiam et Cornelius senatores, ambo venenorum artibus pravis se polluisse confessi, eodem pronuntiante Maximino sunt interfecti. pari sorte etiam procurator monetae extinctus est. Sericum enim et Asbolium supra dictos, quoniam cum hortaretur passim nominare, quos vellent, adiecta religione firmarat, nullum igni vel ferro se puniri iussurum, plumbi validis ictibus interemit. et post hoe flammis Campensem aruspicem dedit, in negotio eius nullo sacramento constrictus.');
        $produit2->setPrice(22);
        $produit2->setEnabled(1);
        $produit2->setAuthor($author1);
        $manager->persist($produit2);

        $diaryal2 = new Diary();
        $diaryal2->setDateDiary(\DateTime::createFromFormat('d/m/Y', '14/06/2017'));
        $diaryal2->setLieu("Statuuntur");
        $diaryal2->setRemainingSpace(20);
        $diaryal2->setEnabled(1);
        $diaryal2->setVip(false);
        $diaryal2->setImage($picture2);
        $diaryal2->setProduct($produit2);
        $manager->persist($diaryal2);

        $produit3 = new Product();
        $produit3->setTitle('Romani');
        $produit3->setDescription('Primi igitur omnium statuuntur Epigonus et Eusebius ob nominum gentilitatem oppressi. praediximus enim Montium sub ipso vivendi termino his vocabulis appellatos fabricarum culpasse tribunos ut adminicula futurae molitioni pollicitos.');
        $produit3->setPrice(4);
        $produit3->setEnabled(1);
        $produit3->setAuthor($author1);
        $manager->persist($produit3);

        $diaryal3 = new Diary();
        $diaryal3->setDateDiary(\DateTime::createFromFormat('d/m/Y', '14/03/2017'));
        $diaryal3->setLieu("Oppressi");
        $diaryal3->setRemainingSpace(30);
        $diaryal3->setEnabled(1);
        $diaryal3->setVip(true);
        $diaryal3->setImage($picture3);
        $diaryal3->setProduct($produit3);
        $manager->persist($diaryal3);

        $produit4 = new Product();
        $produit4->setTitle('Quare');
        $produit4->setDescription('Quare hoc quidem praeceptum, cuiuscumque est, ad tollendam amicitiam valet; illud potius praecipiendum fuit, ut eam diligentiam adhiberemus in amicitiis comparandis, ut ne quando amare inciperemus eum, quem aliquando odisse possemus. Quin etiam si minus felices in diligendo fuissemus, ferendum id Scipio potius quam inimicitiarum tempus cogitandum putabat.');
        $produit4->setPrice(40);
        $produit4->setEnabled(1);
        $produit4->setAuthor($author1);
        $manager->persist($produit4);

        $diaryal4 = new Diary();
        $diaryal4->setDateDiary(\DateTime::createFromFormat('d/m/Y', '19/04/2017'));
        $diaryal4->setLieu("Marcio");
        $diaryal4->setRemainingSpace(30);
        $diaryal4->setEnabled(1);
        $diaryal4->setVip(true);
        $diaryal4->setImage($picture4);
        $diaryal4->setProduct($produit4);
        $manager->persist($diaryal4);


        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
