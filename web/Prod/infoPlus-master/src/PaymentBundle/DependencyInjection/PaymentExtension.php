<?php

namespace PaymentBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PaymentExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loaderYaml = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loaderYaml->load('services.yml');
        $loaderYaml->load('repository.yml');
        $loaderYaml->load('manager.yml');
        $loaderYaml->load('listener.yml');
        $loaderYaml->load('form.yml');

        $container->setParameter('payment.payment_organisms', $config['payment_organisms']);
        $container->setParameter('payment.max_invoice_per_page', $config['max_invoice_per_page']);
        $container->setParameter('payment.max_product_per_page', $config['max_product_per_page']);

    }
}
