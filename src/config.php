<?php
return [
    'db'=>[
        'driver'   => 'mysql',
        'host'     => '127.0.0.1',
        'port'     => '3306',
        'database' => 'cns_loyalty',
        'username' => 'cns_loyalty',
        'password' => 'cns_loyalty',
    ],
    'init'=>[
        'test_user_count'=>10,
        'perms'=>[
            'send_messages',
            'service_api',
            'debug',
            'can_post',
            'can_sall',

        ],
        'groups'=>[
            'user'=>[
                'send_messages',
                'can_post',
            ],
            'moder'=>[
                'send_messages',
                'can_post',
                'can_sall',
            ],
            'admin'=>[
                'send_messages',
                'service_api',
                'can_post',
                'can_sall',
            ],
            'dev'=>[
                'send_messages',
                'service_api',
                'debug',
                'can_post',
                'can_sall',
            ],
            'blocked'=>[
                'send_messages',
                'can_post',
                'can_sall',
            ] 
        ],
    ]
];