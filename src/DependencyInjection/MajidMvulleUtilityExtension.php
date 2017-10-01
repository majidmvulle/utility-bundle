<?php

namespace MajidMvulle\Bundle\UtilityBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MajidMvulleUtilityExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('majidmvulle.utility.mailer.from_email', $config['majidmvulle_utility']['mailer']['from_email']);
        $container->setParameter('majidmvulle.utility.mailer.from_sender_name', $config['majidmvulle_utility']['mailer']['from_sender_name']);
        $container->setParameter('majidmvulle.utility.twilio.sid', $config['majidmvulle_utility']['twilio']['sid']);
        $container->setParameter('majidmvulle.utility.twilio.token', $config['majidmvulle_utility']['twilio']['token']);
        $container->setParameter('majidmvulle.utility.twilio.from_number', $config['majidmvulle_utility']['twilio']['from_number']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    public function getAlias()
    {
        return 'majidmvulle_utility';
    }
}
