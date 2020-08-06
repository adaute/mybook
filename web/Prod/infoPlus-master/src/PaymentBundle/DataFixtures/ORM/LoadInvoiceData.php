<?php

namespace PaymentBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PaymentBundle\Entity\Invoice;

class LoadInvoiceData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user1 = $manager->getRepository("UserBundle:User")->findOneByEmail("president@adresse.fr");

        $product1 = $manager->getRepository("PaymentBundle:Product")->findOneByTitle("Indumentum");

        $invoice1 = new Invoice();
        $invoice1->setPayId('PAY-50W19677146286629LEIDNBQ');
        $invoice1->setCartId('3J6063875B913923S');
        $invoice1->setEmailPayer('infoplusupjv-buyer@gmail.com');
        $invoice1->setFirstNamePayer('test');
        $invoice1->setLastNamePayer('buyer');
        $invoice1->setPayerID('WFUV9V386TGTW');
        $invoice1->setRecipientName('test buyer');
        $invoice1->setLine1('Av. de la Pelouse, 87648672 Mayet');
        $invoice1->setCity('Paris');
        $invoice1->setState('Alsace');
        $invoice1->setPostalCode('75002');
        $invoice1->setCountryCode('FR');
        $invoice1->setDateInvoice(new \DateTime());
        $invoice1->setAmountPrice('22');
        $invoice1->setMerchantId('WHJQ6TMHNE3ZE');
        $invoice1->setMerchantEmail('infoplusupjv-facilitator@gmail.com');
        $invoice1->setProduct($product1);
        $invoice1->setUser($user1);

        $manager->persist($invoice1);

        $invoice2 = new Invoice();
        $invoice2->setPayId('PAY-50W19677149086629LEIDNBQ');
        $invoice2->setCartId('3J6063875B233923S');
        $invoice2->setEmailPayer('infoplusupjv-buyer@gmail.com');
        $invoice2->setFirstNamePayer('test');
        $invoice2->setLastNamePayer('buyer');
        $invoice2->setPayerID('WFUV9V390TGTW');
        $invoice2->setRecipientName('test buyer');
        $invoice2->setLine1('Av. de la Pelouse, 87648672 Mayet');
        $invoice2->setCity('Paris');
        $invoice2->setState('Alsace');
        $invoice2->setPostalCode('75002');
        $invoice2->setCountryCode('FR');
        $invoice2->setDateInvoice(new \DateTime('2017/05/01'));
        $invoice2->setAmountPrice('19.80');
        $invoice2->setMerchantId('WHJQ6TMHNE3ZE');
        $invoice2->setMerchantEmail('infoplusupjv-facilitator@gmail.com');
        $invoice2->setProduct($product1);
        $invoice2->setUser($user1);

        $manager->persist($invoice2);

        $manager->flush();
    }

    public function getOrder()
    {
        return 7;
    }
}
