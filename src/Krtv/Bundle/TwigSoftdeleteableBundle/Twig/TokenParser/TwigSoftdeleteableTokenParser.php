<?php

namespace Krtv\Bundle\TwigSoftdeleteableBundle\Twig\TokenParser;
use Krtv\Bundle\TwigSoftdeleteableBundle\Twig\Node\TwigSoftdeleteableNode;


/**
 * Token Parser for the softdeleteable tag.
 *
 * @author Dmitry Korotovsky <dmitry@korotovsky.io>
 */
class TwigSoftdeleteableTokenParser extends \Twig_TokenParser
{
    /**
     * @param \Twig_Token $token
     * @return TwigSoftdeleteableNode|\Twig_NodeInterface
     */
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $className = null;
        // {% softdeleteable 'FQCN' %}
        if (!$stream->test(\Twig_Token::BLOCK_END_TYPE)) {
            $name = $this->parser->getExpressionParser()->parseExpression();

            $className = $name->getAttribute('value');
        }

        // or just tag {% softdeleteable %}
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);
        // {% endsoftdeleteable %}
        $body = $this->parser->subparse(array($this, 'decideSoftdeleteableEnd'), true);
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new TwigSoftdeleteableNode($className, $body, new \Twig_Node_Expression_AssignName($this->parser->getVarName(), $token->getLine()), $lineno, $this->getTag());
    }

    /**
     * @param \Twig_Token $token
     * @return bool
     */
    public function decideSoftdeleteableEnd(\Twig_Token $token)
    {
        return $token->test('endsoftdeleteable');
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'softdeleteable';
    }
}
