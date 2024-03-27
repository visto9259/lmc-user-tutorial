<?php

return [
    'service_manager' => [
        'delegators' => [
            'lmcuser_register_form' => [
                \User\Form\RegisterFormDelegatorFactory::class,
            ],
        ],
        'aliases' => [
            'lmcuser_base_hydrator' => 'custom_user_hydrator',
        ],
        'factories' => [
            'custom_user_hydrator' => \User\Mapper\BaseUserHydratorFactory::class,
            'lmcuser_user_hydrator' => \User\Mapper\UserHydratorFactory::class,
            'lmcuser_user_mapper' => \User\Mapper\UserMapperFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'lmc-user/user/index' => __DIR__ . '/../view/lmc-user/user/index.phtml',
        ],
    ],
];
