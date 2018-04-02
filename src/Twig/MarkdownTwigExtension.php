<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle\Twig;

/**
 * Class MarkdownTwigExtension.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
class MarkdownTwigExtension extends \Twig_Extension
{
    /**
     * @var Markdown
     */
    private $parser;

    public function __construct(Markdown $parser)
    {
        $this->parser = $parser;
    }

    public function getFilters(): array
    {
        return [
            new \Twig_SimpleFilter(
                'md2html',
                [$this, 'markdownToHtml'],
                ['is_safe' => ['html']]),
        ];
    }

    public function markdownToHtml($content): string
    {
        return $this->parser->toHtml($content);
    }

    public function getName(): string
    {
        return 'majidmvulle_markdown_extension';
    }
}
