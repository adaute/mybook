<?php

namespace PaymentBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('payment');

        $rootNode
            ->children()
            ->variableNode('max_invoice_per_page')->end()
            ->variableNode('max_product_per_page')->end()
            ->arrayNode('payment_organisms')
                    ->children()
                        ->variableNode('default')
                            ->cannotBeEmpty()->end()
                                ->variableNode('client_id')
                                    ->cannotBeEmpty()
                                ->end()
                                ->variableNode('client_password')
                                ->end()
                                ->enumNode('mode')
                                ->values(array('sandbox', 'live'))
                                ->defaultValue('sandbox')
                                ->cannotBeOverwritten()
                                ->cannotBeEmpty()
                                ->end()
                                ->variableNode('return_url')
                                ->cannotBeEmpty()
                                ->end()
                               ->variableNode('cancel_url')
                               ->cannotBeEmpty()
                               ->end()
                               ->booleanNode('verbose_mode')->defaultFalse()->end()
                               ->scalarNode('log_dir')->defaultValue('/var/logs/paypal_payments/')->end()
                            ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
