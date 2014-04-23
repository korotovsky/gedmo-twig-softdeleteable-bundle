<?php

namespace Krtv\Bundle\TwigSoftdeleteableBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

/**
 * Class KrtvTwigSoftdeleteableBundleExtension
 * @package Krtv\Bundle\TwigSoftdeleteableBundle\DependencyInjection
 */
class KrtvTwigSoftdeleteableExtension extends Extension
{
    /**
     * Loads the Sms configuration.
     *
     * @param array $configs An array of configuration settings
     * @param ContainerBuilder $container A ContainerBuilder instance
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('config.yml');

        $parameterBag = $container->getParameterBag();
        $entityManagerId = $parameterBag->get('krtv.twig.gedmo_softdeleteable.entity_manager');

        $extension = $container->getDefinition('krtv.twig.gedmo_softdeleteable');
        $extension->addArgument(new Reference($entityManagerId));
    }
}
