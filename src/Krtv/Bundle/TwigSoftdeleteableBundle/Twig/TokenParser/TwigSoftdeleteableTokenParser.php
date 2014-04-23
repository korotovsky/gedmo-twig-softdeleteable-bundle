<?php

namespace Krtv\Bundle\TwigSoftdeleteableBundle\Twig\TokenParser;

use Symfony\Bridge\Twig\Node\StopwatchNode;

/**
 * Token Parser for the softdeleteable tag.
 *
 * @author Dmitry Korotovsky <dmitry@korotovsky.io>
 */
class TwigSoftdeleteableTokenParser extends \Twig_TokenParser
{
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        // {% softdeleteable 'FQCN' %}
        $name = $this->parser->getExpressionParser()->parseExpression();

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        // {% endsoftdeleteable %}
        $body = $this->parser->subparse(array($this, 'decideSoftdeleteableEnd'), true);
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new StopwatchNode($name, $body, new \Twig_Node_Expression_AssignName($this->parser->getVarName(), $token->getLine()), $lineno, $this->getTag());
    }

    public function decideSoftdeleteableEnd(\Twig_Token $token)
    {
        return $token->test('endsoftdeleteable');
    }

    public function getTag()
    {
        return 'softdeleteable';
    }
}
