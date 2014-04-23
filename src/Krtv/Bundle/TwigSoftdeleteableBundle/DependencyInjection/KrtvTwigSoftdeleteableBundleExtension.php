<?php

namespace Krtv\Bundle\TwigSoftdeleteableBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

/**
 * Class KrtvTwigSoftdeleteableBundleExtension
 * @package Krtv\Bundle\TwigSoftdeleteableBundle\DependencyInjection
 */
class KrtvTwigSoftdeleteableBundleExtension extends Extension
{
    /**
     * Loads the Sms configuration.
     *
     * @param array            $configs   An array of configuration settings
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('config.yml');
    }
}
