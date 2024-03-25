<?php

return [
    'service_manager' => [
        'delegators' => [
            'lmcuser_register_form' => [
                \User\Form\RegisterFormDelegatorFactory::class,
            ],
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'lmc-user/user/index' => __DIR__ . '/../view/lmc-user/user/index.phtml',
        ],
    ],
];
