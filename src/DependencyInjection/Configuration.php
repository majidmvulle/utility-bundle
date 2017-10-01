<?php

namespace MajidMvulle\Bundle\UtilityBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
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
        $rootNode = $treeBuilder->root('majidmvulle');

        $rootNode
            ->children()
                ->arrayNode('utility')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('mailer')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('from_email')->defaultValue('')->end()
                                ->scalarNode('from_sender_name')->defaultValue('')->end()
                            ->end()
                        ->end()//mailer
                        ->arrayNode('twilio')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('sid')->defaultValue('')->end()
                                ->scalarNode('token')->defaultValue('')->end()
                                ->scalarNode('from_number')->defaultValue('')->end()
                            ->end()
                        ->end()//twilio
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}