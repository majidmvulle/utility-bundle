<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle\Request\ParamConverter;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NoResultException;
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
     * @var ManagerRegistry
     */
    private $registry;

    public function __construct(ManagerRegistry $registry, AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->registry = $registry;
        parent::__construct($registry);
    }

    public function apply(Request $request, ParamConverter $configuration): bool
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

    public function supports(ParamConverter $configuration): bool
    {
        $actions = [self::CREATE, self::VIEW, self::EDIT, self::DELETE];
        $options = $this->getOptions($configuration);

        if (isset($options['action'])) {
            return in_array($options['action'], $actions, true);
        }

        return false;
    }

    private function getOptions(ParamConverter $configuration): array
    {
        $defaultValues = ['entity_manager' => null, 'exclude' => [], 'mapping' => [], 'strip_null' => false, 'expr' => null, 'id' => null, 'repository_method' => null, 'map_method_signature' => false];
        $passedOptions = $configuration->getOptions();
        if (isset($passedOptions['repository_method'])) {
            @trigger_error('The repository_method option of @ParamConverter is deprecated and will be removed in 5.0. Use the expr option or @Entity.', E_USER_DEPRECATED);
        }
        if (isset($passedOptions['map_method_signature'])) {
            @trigger_error('The map_method_signature option of @ParamConverter is deprecated and will be removed in 5.0. Use the expr option or @Entity.', E_USER_DEPRECATED);
        }
        $extraKeys = array_diff(array_keys($passedOptions), array_keys($defaultValues));
        if ($extraKeys) {
            throw new \InvalidArgumentException(sprintf('Invalid option(s) passed to @%s: %s', $this->getAnnotationName($configuration), implode(', ', $extraKeys)));
        }

        return array_replace($defaultValues, $passedOptions);
    }

    private function getAnnotationName(ParamConverter $configuration): string
    {
        $r = new \ReflectionClass($configuration);

        return $r->getShortName();
    }

    private function find($class, Request $request, $options, $name): ?mixed
    {
        if ($options['mapping'] || $options['exclude']) {
            return false;
        }
        $id = $this->getIdentifier($request, $options, $name);
        if (false === $id || null === $id) {
            return false;
        }
        if ($options['repository_method']) {
            $method = $options['repository_method'];
        } else {
            $method = 'find';
        }
        try {
            return $this->getManager($options['entity_manager'], $class)->getRepository($class)->$method($id);
        } catch (NoResultException $e) {
            return null;
        }
    }

    private function getIdentifier(Request $request, $options, $name): mixed
    {
        if (null !== $options['id']) {
            if (!is_array($options['id'])) {
                $name = $options['id'];
            } elseif (is_array($options['id'])) {
                $id = [];
                foreach ($options['id'] as $field) {
                    $id[$field] = $request->attributes->get($field);
                }

                return $id;
            }
        }
        if ($request->attributes->has($name)) {
            return $request->attributes->get($name);
        }
        if ($request->attributes->has('id') && !$options['id']) {
            return $request->attributes->get('id');
        }

        return false;
    }

    private function findOneBy($class, Request $request, $options): ?mixed
    {
        if (!$options['mapping']) {
            $keys = $request->attributes->keys();
            $options['mapping'] = $keys ? array_combine($keys, $keys) : [];
        }
        foreach ($options['exclude'] as $exclude) {
            unset($options['mapping'][$exclude]);
        }
        if (!$options['mapping']) {
            return false;
        }
        // if a specific id has been defined in the options and there is no corresponding attribute
        // return false in order to avoid a fallback to the id which might be of another object
        if ($options['id'] && null === $request->attributes->get($options['id'])) {
            return false;
        }
        $criteria = [];
        $em = $this->getManager($options['entity_manager'], $class);
        $metadata = $em->getClassMetadata($class);
        $mapMethodSignature = $options['repository_method'] && $options['map_method_signature'] && true === $options['map_method_signature'];
        foreach ($options['mapping'] as $attribute => $field) {
            if ($metadata->hasField($field) || ($metadata->hasAssociation($field) && $metadata->isSingleValuedAssociation($field)) || $mapMethodSignature) {
                $criteria[$field] = $request->attributes->get($attribute);
            }
        }
        if ($options['strip_null']) {
            $criteria = array_filter($criteria, function ($value) {
                return null !== $value;
            });
        }
        if (!$criteria) {
            return false;
        }
        if ($options['repository_method']) {
            $repositoryMethod = $options['repository_method'];
        } else {
            $repositoryMethod = 'findOneBy';
        }
        try {
            if ($mapMethodSignature) {
                return $this->findDataByMapMethodSignature($em, $class, $repositoryMethod, $criteria);
            }

            return $em->getRepository($class)->$repositoryMethod($criteria);
        } catch (NoResultException $e) {
            return null;
        }
    }

    private function getManager($name, $class)
    {
        if (null === $name) {
            return $this->registry->getManagerForClass($class);
        }

        return $this->registry->getManager($name);
    }

    private function findDataByMapMethodSignature($em, $class, $repositoryMethod, $criteria): mixed
    {
        $arguments = [];
        $repository = $em->getRepository($class);
        $ref = new \ReflectionMethod($repository, $repositoryMethod);
        foreach ($ref->getParameters() as $parameter) {
            if (array_key_exists($parameter->name, $criteria)) {
                $arguments[] = $criteria[$parameter->name];
            } elseif ($parameter->isDefaultValueAvailable()) {
                $arguments[] = $parameter->getDefaultValue();
            } else {
                throw new \InvalidArgumentException(sprintf('Repository method "%s::%s" requires that you provide a value for the "$%s" argument.', get_class($repository), $repositoryMethod, $parameter->name));
            }
        }

        return $ref->invokeArgs($repository, $arguments);
    }
}
