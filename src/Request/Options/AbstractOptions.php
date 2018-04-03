<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle\Request\Options;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractOptions.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
abstract class AbstractOptions implements OptionsInterface
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var OptionsResolver
     */
    private $resolver;

    public function __construct(array $options = [])
    {
        $this->resolver = new OptionsResolver();
        $this->configureOptions($this->resolver);
        $this->options = $this->resolver->resolve($options);
    }

    public function has($option): bool
    {
        return isset($this->options[$option]);
    }

    public function get($option)
    {
        if (!$this->has($option)) {
            return;
        }

        return $this->options[$option];
    }
}
