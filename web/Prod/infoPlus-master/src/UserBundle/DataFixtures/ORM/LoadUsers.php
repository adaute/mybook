<?php

namespace UserBundle\DataFixtures\ORM;

/*http://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html*/

use UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsers extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
        $factory = $this->container->get('security.encoder_factory');

        $picture1 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("president.jpg");
        $picture2 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("secretaire.jpg");
        $picture3 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("tresorier.jpg");
        $picture4 = $manager->getRepository("CoreBundle:Image")->findOneByAlt("membre.jpg");

        $rank1 = $manager->getRepository("UserBundle:Rank")->findOneBySlug("president");
        $rank2 = $manager->getRepository("UserBundle:Rank")->findOneBySlug("secretaire");
        $rank3 = $manager->getRepository("UserBundle:Rank")->findOneBySlug("tresorier");
        $rank4 = $manager->getRepository("UserBundle:Rank")->findOneBySlug("membre");

        $user = new User();
        $user->setUsername('visiteur');
        $user->setEmail('visiteur@adresse.fr');
        $user->setFirstName('visiteurFirstName');
        $user->setLastName('visiteurLastName');
        $user->setPlainPassword('visiteur123');
        $user->setRoles(['ROLE_VISITOR']);
        $user->setCguRead(true);
        $user->setIsActive(true);
        $encoder = $factory->getEncoder($user);
        $user->encodePassword($encoder);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@adresse.fr');
        $user->setFirstName('adminFirstName');
        $user->setLastName('adminLastName');
        $user->setPlainPassword('admin123');
        $user->setCguRead(true);
        $user->setIsActive(true);
        $user->setRoles(['ROLE_ADMIN']);
        $encoder = $factory->getEncoder($user);
        $user->encodePassword($encoder);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('editeur');
        $user->setEmail('editeur@adresse.fr');
        $user->setFirstName('editeurFirstName');
        $user->setLastName('editeurLastName');
        $user->setPlainPassword('editeur123');
        $user->setCguRead(true);
        $user->setIsActive(true);
        $user->setRoles(['ROLE_EDITOR']);
        $encoder = $factory->getEncoder($user);
        $user->encodePassword($encoder);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('president');
        $user->setEmail('president@adresse.fr');
        $user->setFirstName('Accusatoribus');
        $user->setLastName('Criminis');
        $user->setPlainPassword('president123');
        $user->setCguRead(true);
        $user->setIsActive(true);
        $user->setRoles(['ROLE_ADMIN']);
        $encoder = $factory->getEncoder($user);
        $user->encodePassword($encoder);
        $user->setRank($rank1);
        $user->setImage($picture1);
        $user->setCitation("Magnificus vitiis lasciviam vitiis incondita.");
        $manager->persist($user);

        $user = new User();
        $user->setUsername('secretaire');
        $user->setEmail('secretaire@adresse.fr');
        $user->setFirstName('Campensem');
        $user->setLastName('Extinctus');
        $user->setPlainPassword('secretaire123');
        $user->setCguRead(true);
        $user->setIsActive(true);
        $user->setRoles(['ROLE_EDITOR']);
        $encoder = $factory->getEncoder($user);
        $user->encodePassword($encoder);
        $user->setRank($rank2);
        $user->setImage($picture2);
        $user->setCitation("Non nunc summatem ob et.");
        $manager->persist($user);

        $user = new User();
        $user->setUsername('tresorier');
        $user->setEmail('tresorier@adresse.fr');
        $user->setFirstName('Ascraeus');
        $user->setLastName('Quidam');
        $user->setPlainPassword('tresorier123');
        $user->setCguRead(true);
        $user->setIsActive(true);
        $user->setRoles(['ROLE_EDITOR']);
        $encoder = $factory->getEncoder($user);
        $user->encodePassword($encoder);
        $user->setRank($rank3);
        $user->setImage($picture3);
        $user->setCitation("Vidisse summatem summatem tamquam advena.");
        $manager->persist($user);

        $user = new User();
        $user->setUsername('membre');
        $user->setEmail('membre@adresse.fr');
        $user->setFirstName('FirstName');
        $user->setLastName('LastName');
        $user->setPlainPassword('membre123');
        $user->setCguRead(true);
        $user->setIsActive(true);
        $user->setRoles(['ROLE_VISITOR']);
        $encoder = $factory->getEncoder($user);
        $user->encodePassword($encoder);
        $user->setRank($rank4);
        $user->setImage($picture4);
        $user->setCitation("Delectemur tamquam adferunt autem commorati.");
        $manager->persist($user);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder()
    {
        return 2;
    }
}
