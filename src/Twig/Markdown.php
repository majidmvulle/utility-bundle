<?php

namespace MajidMvulle\Bundle\UtilityBundle\Twig;

/**
 * Class Markdown.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
class Markdown
{
    /**
     * @var \Parsedown
     */
    private $parser;

    public function __construct()
    {
        $this->parser = new \Parsedown();
    }

    public function toHtml($text): string
    {
        $html = $this->parser->text($text);

        return $html;
    }
}
