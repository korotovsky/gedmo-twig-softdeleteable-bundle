<?php


namespace Krtv\Bundle\TwigSoftdeleteableBundle\Twig\Node;

/**
 * Represents a softdeleteable node.
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
class TwigSoftdeleteableNode extends \Twig_Node
{
    public function __construct(\Twig_NodeInterface $name, $body, \Twig_Node_Expression_AssignName $var, $lineno = 0, $tag = null)
    {
        parent::__construct(array('body' => $body, 'name' => $name, 'var' => $var), array(), $lineno, $tag);
    }

    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write('')
            ->subcompile($this->getNode('var'))
            ->raw(' = ')
            ->subcompile($this->getNode('name'))
            ->write(";\n")
            ->write("\$this->env->getExtension('krtv.twig_softdeleteable')->disable(")
            ->subcompile($this->getNode('var'))
            ->raw(", 'template');\n")
            ->subcompile($this->getNode('body'))
            ->write("\$this->env->getExtension('krtv.twig_softdeleteable')->enable(")
            ->subcompile($this->getNode('var'))
            ->raw(");\n")
        ;
    }
}
