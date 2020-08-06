<?php

namespace TopicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TopicBundle\Entity\Topic;

class LoadTopicData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $author1 = $manager->getRepository("UserBundle:User")->findOneByEmail("president@adresse.fr");
        $author2 = $manager->getRepository("UserBundle:User")->findOneByEmail("secretaire@adresse.fr");
        $author3 = $manager->getRepository("UserBundle:User")->findOneByEmail("tresorier@adresse.fr");

        $picture1 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("road-2199357_1280.jpg");
        $picture2 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("fox-1540833_1280.jpg");
        $picture3 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("landscape-2090495_1920.jpg");
        $picture4 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("garda-202065_1280.jpg");
        $picture5 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("mountain-1504197_1280.jpg");
        $picture6 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("horsesdhoe-bend-1908283_1280.jpg");

        $topical1 = new Topic();
        $topical1->setTitle('Nefanda mors scelere non letali.');
        $topical1->setDescription('Utque proeliorum periti rectores primo catervas densas opponunt et fortes, deinde leves armaturas, post iaculatores ultimasque subsidiales acies, si fors adegerit, iuvaturas, ita praepositis urbanae familiae');
        $topical1->setAuthor($author1);
        $topical1->setPosition(0);
        $topical1->setEnabled(0);
        $manager->persist($topical1);

        $topical2 = new Topic();
        $topical2->setTitle('Caritas conciliavit inter intellegi in.');
        $topical2->setDescription('suspensae digerentibus sollicite, quos insignes faciunt virgae dexteris aptatae velut tessera data castrensi iuxta vehiculi frontem omne textrinum');
        $topical2->setAuthor($author1);
        $topical2->setImage($picture1);
        $topical2->setPosition(1);
        $topical2->setEnabled(1);
        $manager->persist($topical2);

        $topical3 = new Topic();
        $topical3->setTitle('Nos sententias erga sint ut.');
        $topical3->setDescription('Haec dum oriens diu perferret, caeli reserato tepore Constantius consulatu suo septies et Caesaris ter egressus Arelate Valentiam petit');
        $topical3->setAuthor($author2);
        $topical3->setImage($picture2);
        $topical3->setPosition(2);
        $topical3->setEnabled(1);
        $manager->persist($topical3);

        $topical4 = new Topic();
        $topical4->setTitle('Debet sermonum quidem sermonum omni.');
        $topical4->setDescription('Etenim si attendere diligenter, existimare vere de omni hac causa volueritis, sic constituetis, iudices, nec descensurum quemquam ad hanc accusationem fuisse, cui, utrum vellet, liceret, nec, cum descendisset, quicquam habiturum spei fuisse, nisi alicuius intolerabili libidine et nimis acerbo odio niteretur. Sed ego Atratino, humanissimo atque optimo adulescenti meo necessario, ignosco, qui habet excusationem vel pietatis vel necessitatis vel aetatis. Si voluit accusare, pietati tribuo, si iussus est, necessitati, si speravit aliquid, pueritiae. Ceteris non modo nihil ignoscendum, sed etiam acriter est resistendum.');
        $topical4->setAuthor($author3);
        $topical4->setImage($picture3);
        $topical4->setPosition(3);
        $topical4->setEnabled(1);
        $manager->persist($topical4);

        $topical5 = new Topic();
        $topical5->setTitle('Bene poterat occurrere quorum ordinibus.');
        $topical5->setDescription('Nihil est enim virtute amabilius, nihil quod magis adliciat ad diligendum, quippe cum propter virtutem et probitatem etiam eos, quos numquam vidimus, quodam modo diligamus. Quis est qui C. Fabrici, M\'. Curi non cum caritate aliqua benevola memoriam usurpet, quos numquam viderit? quis autem est, qui Tarquinium Superbum, qui Sp. Cassium, Sp. Maelium non oderit? Cum duobus ducibus de imperio in Italia est decertatum, Pyrrho et Hannibale; ab altero propter probitatem eius non nimis alienos animos habemus, alterum propter crudelitatem semper haec civitas oderit.');
        $topical5->setAuthor($author2);
        $topical5->setImage($picture4);
        $topical5->setPosition(4);
        $topical5->setEnabled(1);
        $manager->persist($topical5);

        $topical6 = new Topic();
        $topical6->setTitle('Ipse hoc amicitiae id quidem.');
        $topical6->setDescription('Iamque lituis cladium concrepantibus internarum non celate ut antea turbidum saeviebat ingenium a veri consideratione detortum et nullo inpositorum vel conpositorum fidem sollemniter inquirente nec discernente a societate noxiorum insontes velut exturbatum e iudiciis fas omne discessit, et causarum legitima silente defensione carnifex rapinarum sequester et obductio capitum et bonorum ubique multatio versabatur per orientales provincias, quas recensere puto nunc oportunum absque Mesopotamia digesta, cum bella Parthica dicerentur, et Aegypto, quam necessario aliud reieci ad tempus.');
        $topical6->setAuthor($author1);
        $topical6->setImage($picture5);
        $topical6->setPosition(5);
        $topical6->setEnabled(1);
        $manager->persist($topical6);

        $topical7 = new Topic();
        $topical7->setTitle('Idque nec cursibus magnitudine bellorum.');
        $topical7->setDescription('Utque proeliorum periti rectores primo catervas densas opponunt et fortes, deinde leves armaturas, post iaculatores ultimasque subsidiales acies, si fors adegerit, iuvaturas, ita praepositis urbanae familiae suspensae digerentibus sollicite, quos insignes faciunt virgae dexteris aptatae velut tessera data castrensi iuxta vehiculi frontem omne textrinum incedit: huic atratum coquinae iungitur ministerium, dein totum promiscue servitium cum otiosis plebeiis de vicinitate coniunctis: postrema multitudo spadonum a senibus in pueros desinens, obluridi distortaque lineamentorum conpage deformes, ut quaqua incesserit quisquam cernens mutilorum hominum agmina detestetur memoriam Samiramidis reginae illius veteris, quae teneros mares castravit omnium prima velut vim iniectans naturae, eandemque ab instituto cursu retorquens, quae inter ipsa oriundi crepundia per primigenios seminis fontes tacita quodam modo lege vias propagandae posteritatis ostendit.');
        $topical7->setAuthor($author3);
        $topical7->setImage($picture6);
        $topical7->setPosition(6);
        $topical7->setEnabled(1);
        $manager->persist($topical7);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
