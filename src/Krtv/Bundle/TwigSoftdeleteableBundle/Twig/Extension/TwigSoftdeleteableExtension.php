<?php

namespace Krtv\Bundle\TwigSoftdeleteableBundle\Twig\Extension;

use Doctrine\ORM\EntityManagerInterface;
use Krtv\Bundle\TwigSoftdeleteableBundle\Twig\TokenParser\TwigSoftdeleteableTokenParser;

/**
 * Twig extension for the softdeleteable extension.
 *
 * @author Dmitry Korotovsky <dmitry@korotovsky.io>
 */
class TwigSoftdeleteableExtension extends \Twig_Extension
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function disable($class = null)
    {
        // Disable soft deleteable
    }

    public function enable($class = null)
    {
        // Disable soft deleteable
    }

    public function getTokenParsers()
    {
        return array(
            /*
             * {% softdeleteable %} or {% softdeleteable FQCN %}
             * Some stuff which will be recorded on the timeline
             * {% endstopwatch %}
             */
            new TwigSoftdeleteableTokenParser(),
        );
    }

    public function getName()
    {
        return 'krtv.twig_softdeleteable';
    }
}
