<?php

namespace Krtv\Bundle\TwigSoftdeleteableBundle\Twig\Extension;

use Doctrine\ORM\EntityManagerInterface;
use Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter;
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
     * @var \SplStack
     */
    protected $classStack;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->classStack = new \SplStack();
        $this->entityManager = $entityManager;
    }

    /**
     * @param null $class
     * @return void
     */
    public function disable($class = null)
    {
        if ($class !== null) {
            $this->classStack->push($class);
        }

        if ($this->entityManager->getFilters()->isEnabled('softdeleteable')) {
            if ($class !== null) {
                /** @var SoftDeleteableFilter $filter */
                $filter = $this->entityManager->getFilters()->getFilter('softdeleteable');
                $filter->disableForEntity($class);
            } else {
                $this->entityManager->getFilters()->disable('softdeleteable');
            }
        }
    }

    /**
     * That nested case will be corrected and fully supported
     * {% softdeleteable %}
     *    <span>
     *       {% softdeleteable 'Acme\Bundle\CoreBundle\Entity\Foo' %}
     *           {% softdeleteable %}
     *               {% softdeleteable 'Acme\Bundle\CoreBundle\Entity\Bar' %}
     *                   {{ object.owner.fullName }}
     *               {% endsoftdeleteable %}
     *           {% endsoftdeleteable %}
     *       {% endsoftdeleteable %}
     *    </span>
     * {% endsoftdeleteable %}
     * @param null $class
     * @return bool
     */
    public function enable($class = null)
    {
        if (!$this->entityManager->getFilters()->isEnabled('softdeleteable')) {
            if ($class !== null) {
                // Nested tags case.
                // {% softdeleteable 'FQCN' %} inside {% softdeleteable %}
                // So, just pop classes stack
                $this->classStack->pop();
            } else {
                // When we enable globally we need to restore disabled entities
                $this->entityManager->getFilters()->enable('softdeleteable');

                // Populate from stack of disabled entities
                /** @var SoftDeleteableFilter $filter */
                $filter = $this->entityManager->getFilters()->getFilter('softdeleteable');
                foreach ($this->classStack as $class) {
                    $filter->disableForEntity($class);
                }
            }
        } else {
            if ($class !== null) {
                /** @var SoftDeleteableFilter $filter */
                $filter = $this->entityManager->getFilters()->getFilter('softdeleteable');
                $filter->enableForEntity($class);

                $this->classStack->pop();
            }
        }
    }

    /**
     * @return array
     */
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

    /**
     * @return string
     */
    public function getName()
    {
        return 'krtv.twig_softdeleteable';
    }
}
