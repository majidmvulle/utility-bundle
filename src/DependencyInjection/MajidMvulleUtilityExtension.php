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

        $container->setParameter('majidmvulle.utility.mailer.from_email', $config['mailer']['from_email']);
        $container->setParameter('majidmvulle.utility.mailer.from_sender_name', $config['mailer']['from_sender_name']);
        $container->setParameter('majidmvulle.utility.twilio.sid', $config['twilio']['sid']);
        $container->setParameter('majidmvulle.utility.twilio.token', $config['twilio']['token']);
        $container->setParameter('majidmvulle.utility.twilio.from_number', $config['twilio']['from_number']);
    }

    public function getAlias()
    {
        return 'majidmvulle_utility';
    }
}
