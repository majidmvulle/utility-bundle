<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle\EventListener;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * Class OptionsAnnotationListener.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
class OptionsAnnotationListener
{
    /**
     * @var AnnotationReader
     */
    private $annotationsReader;

    public function __construct(AnnotationReader $annotationsReader)
    {
        $this->annotationsReader = $annotationsReader;
    }

    public function onKernelController(FilterControllerEvent $event): void
    {
        $controller = $event->getController();
        $request = $event->getRequest();

        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony2 but it may happen.
         * If it is a class, it comes in array format
         *
         */
        if (!is_array($controller)) {
            return;
        }

        list($controllerObject, $methodName) = $controller;
        $optionsAnnotation = 'MajidMvulle\Bundle\UtilityBundle\Annotation\Options';

        $controllerReflectionObject = new \ReflectionObject($controllerObject);
        $reflectionMethod = $controllerReflectionObject->getMethod($methodName);
        $methodAnnotation = $this->annotationsReader->getMethodAnnotation($reflectionMethod, $optionsAnnotation);

        if ($methodAnnotation) {
            $request->attributes->set($methodAnnotation->getName(), $methodAnnotation->setRequestParams($request->query->all()));
        }
    }
}
