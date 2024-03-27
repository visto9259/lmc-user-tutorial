<?php

namespace User\Mapper;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class UserHydratorFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new UserHydrator($container->get('lmcuser_base_hydrator'));
    }
}
