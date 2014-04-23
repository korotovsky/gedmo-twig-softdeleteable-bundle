<?php


namespace Krtv\Bundle\TwigSoftdeleteableBundle\Twig\Node;

/**
 * Represents a softdeleteable node.
 *
 * @author Dmitry Korotovsky <dmitry@korotovsky.io>
 */
class TwigSoftdeleteableNode extends \Twig_Node
{
    public function __construct($className = null, $body, \Twig_Node_Expression_AssignName $var, $lineno = 0, $tag = null)
    {
        parent::__construct(array('body' => $body, 'var' => $var), array('className' => $className), $lineno, $tag);
    }

    public function compile(\Twig_Compiler $compiler)
    {
        $className = $this->getAttribute('className');

        $compiler->addDebugInfo($this)
            ->write('');

        // Compile disable
        $compiler->write("\$this->env->getExtension('krtv.twig_softdeleteable')->disable(");
        if ($className !== null) {
            $compiler->raw("'");
            $compiler->raw($className);
            $compiler->raw("'");
        }
        $compiler->raw(");\n");

        // Compile body
        $compiler->subcompile($this->getNode('body'));

        // Compile enable back
        $compiler->write("\$this->env->getExtension('krtv.twig_softdeleteable')->enable(");
        if ($className !== null) {
            $compiler->raw("'");
            $compiler->raw($className);
            $compiler->raw("'");
        }
        $compiler->raw(");\n");
    }
}
