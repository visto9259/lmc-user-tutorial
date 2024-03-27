<?php

namespace User\Mapper;

use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class UserMapperFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $options = $container->get('lmcuser_module_options');
        $dbAdapter = $container->get('lmcuser_laminas_db_adapter');
        $hydrator = $container->get('lmcuser_user_hydrator');


        $entityClass = $options->getUserEntityClass();
        $hydratingResultSet = new HydratingResultSet($hydrator, new $entityClass());

        $tableName = $options->getTableName();
        $tableGateway = new TableGateway($tableName, $dbAdapter, [], $hydratingResultSet);

        return new UserMapper($tableGateway, $hydrator);
    }
}
