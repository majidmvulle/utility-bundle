<?php

namespace MajidMvulle\Bundle\UtilityBundle\Request\ParamConverter;

use Doctrine\Common\Persistence\ManagerRegistry;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DoctrineParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class SecureDoctrineParamConverter.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 *
 * @DI\Service()
 * @DI\Tag(name="request.param_converter",  attributes={"converter"="utility.secure_doctrine_param_converter", "priority"=1}))
 */
class SecureDoctrineParamConverter extends DoctrineParamConverter
{
    const CREATE = 'create';
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';

    /**
     * @var AuthorizationChecker
     */
    private $authorizationChecker;

    /**
     * SecureDoctrineParamConverter Constructor.
     *
     * @DI\InjectParams({
     *  "registry" = @DI\Inject("doctrine"),
     *  "authorizationChecker" = @DI\Inject("security.authorization_checker")
     * })
     *
     * @param ManagerRegistry      $registry
     * @param AuthorizationChecker $authorizationChecker
     */
    public function __construct(ManagerRegistry $registry, AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
        parent::__construct($registry);
    }

    /**
     *  {@inheritdoc}
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        //Copied from parent
        $name = $configuration->getName();
        $class = $configuration->getClass();
        $options = $this->getOptions($configuration);

        if (null === $request->attributes->get($name, false)) {
            $configuration->setIsOptional(true);
        }

        // find by identifier?
        if (false === $object = $this->find($class, $request, $options, $name)) {
            // find by criteria
            if (false === $object = $this->findOneBy($class, $request, $options)) {
                if ($configuration->isOptional()) {
                    $object = null;
                } else {
                    throw new \LogicException('Unable to guess how to get a Doctrine instance from the request information.');
                }
            }
        }

        if (null === $object && false === $configuration->isOptional()) {
            throw new NotFoundHttpException(sprintf('%s object not found.', $class));
        }

        //Custom permission checker
        if (!$this->authorizationChecker->isGranted($options['action'], $object)) {
            throw new AccessDeniedException();
        }

        $request->attributes->set($name, $object);

        return true;
    }

    /**
     *  {@inheritdoc}
     */
    public function supports(ParamConverter $configuration)
    {
        $actions = [self::CREATE, self::VIEW, self::EDIT, self::DELETE];
        $options = $this->getOptions($configuration);

        if (isset($options['action'])) {
            return in_array($options['action'], $actions, true);
        }

        return false;
    }
}
