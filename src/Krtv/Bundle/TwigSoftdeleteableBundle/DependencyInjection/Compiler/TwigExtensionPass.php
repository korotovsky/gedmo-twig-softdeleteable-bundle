<?php

namespace Krtv\Bundle\TwigSoftdeleteableBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class TwigExtension
 * @package Krtv\Bundle\TwigSoftdeleteableBundle\DependencyInjection
 */
class TwigExtensionPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     */
    public function process(ContainerBuilder $container)
    {
        $parameterBag = $container->getParameterBag();

        $extensionClass = $parameterBag->get('krtv.twig.gedmo_softdeleteable.class');
        $entityManagerId = $parameterBag->get('krtv.twig.gedmo_softdeleteable.entity_manager');

        if ($container->has($entityManagerId) === false) {
            throw new InvalidArgumentException('EntityManager not found');
        }

        $definition = new Definition($extensionClass);
        $definition->addArgument(new Reference($entityManagerId));
        $definition->addTag('twig.extension');

        $container->set('krtv.twig.gedmo_softdeleteable', $definition);
    }
}
