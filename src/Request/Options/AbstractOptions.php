<?php

namespace MajidMvulle\UtilityBundle\Request\Options;

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

    /**
     * AbstractOptions Constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->resolver = new OptionsResolver();
        $this->configureOptions($this->resolver);
        $this->options = $this->resolver->resolve($options);
    }

    /**
     * @param $option
     *
     * @return bool
     */
    public function has($option)
    {
        return isset($this->options[$option]);
    }

    /**
     * @param $option
     *
     * @return string|null
     */
    public function get($option)
    {
        if (!$this->has($option)) {
            return null;
        }

        return $this->options[$option];
    }
}
