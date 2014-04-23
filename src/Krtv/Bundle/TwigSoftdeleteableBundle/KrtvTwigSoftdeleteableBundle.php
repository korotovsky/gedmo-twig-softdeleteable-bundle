<?php

namespace Krtv\Bundle\TwigSoftdeleteableBundle;

use Krtv\Bundle\TwigSoftdeleteableBundle\DependencyInjection\Compiler\TwigExtensionPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class KrtvTwigSoftdeleteableBundle
 * @package Krtv\Bundle\TwigSoftdeleteableBundle
 */
class KrtvTwigSoftdeleteableBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new TwigExtensionPass());
    }
}
