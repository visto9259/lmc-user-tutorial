<?php

namespace User\Mapper;

use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\Strategy\ExplodeStrategy;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class BaseUserHydratorFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $hydrator = new ClassMethodsHydrator();
        $hydrator->addStrategy('roles', new ExplodeStrategy(';'));
        return $hydrator;
    }
}
