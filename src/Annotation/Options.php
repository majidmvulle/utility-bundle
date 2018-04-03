<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;
use MajidMvulle\Bundle\UtilityBundle\Request\Options\ListOptions;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationAnnotation;

/**
 * Class Options.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 *
 * @Annotation
 * @Target("METHOD")
 */
class Options extends ConfigurationAnnotation
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var array
     */
    protected $requestParams = [];

    public function __construct(array $values)
    {
        parent::__construct($values);
        if (!class_exists($this->class)) {
            throw new \RuntimeException('Options annotation requires an existing class argument!');
        }
    }

    public function setValue($class): void
    {
        $this->class = $class;
    }

    public function getName(): string
    {
        return $this->name ?: 'options';
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function setClass($class): void
    {
        $this->class = $class;
    }

    public function getRequestParams(): array
    {
        return $this->requestParams;
    }

    public function setRequestParams($requestParams): ListOptions
    {
        $this->requestParams = $requestParams;

        return new $this->class($requestParams);
    }

    public function getAliasName(): string
    {
        return 'options';
    }

    public function allowArray(): bool
    {
        return false;
    }
}
