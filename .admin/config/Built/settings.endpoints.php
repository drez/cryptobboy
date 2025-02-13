<?php

namespace App;


$table['authy'] = [
    'id_authy' => [
        'type' => 'INTEGER',
    ],
    'validation_key' => [
        'type' => 'VARCHAR',
    ],
    'username' => [
        'type' => 'VARCHAR',
        'description' => 'Username',
    ],
    'fullname' => [
        'type' => 'VARCHAR',
        'description' => 'Fullname',
    ],
    'email' => [
        'type' => 'VARCHAR',
        'description' => 'Email',
    ],
    'passwd_hash' => [
        'type' => 'VARCHAR',
        'description' => 'Password',
    ],
    'expire' => [
        'type' => 'DATE',
        'description' => 'Expiration',
    ],
    'deactivate' => [
        'type' => 'ENUM',
        'description' => 'Deactivated',
        'valueSet' => null,
    ],
    'is_root' => [
        'type' => 'ENUM',
    ],
    'id_authy_group' => [
        'type' => 'INTEGER',
        'description' => 'Primary group',
    ],
    'is_system' => [
        'type' => 'ENUM',
    ],
    'rights_all' => [
        'type' => 'LONGVARCHAR',
        'description' => 'Rights',
    ],
    'rights_group' => [
        'type' => 'LONGVARCHAR',
        'description' => 'Rights group',
    ],
    'rights_owner' => [
        'type' => 'LONGVARCHAR',
        'description' => 'Rights owner',
    ],
    'onglet' => [
        'type' => 'LONGVARCHAR',
    ],
    'date_creation' => [
        'type' => 'TIMESTAMP',
    ],
    'date_modification' => [
        'type' => 'TIMESTAMP',
    ],
    'id_group_creation' => [
        'type' => 'INTEGER',
    ],
    'id_creation' => [
        'type' => 'INTEGER',
    ],
    'id_modification' => [
        'type' => 'INTEGER',
    ],
];

$query['authy'] = [
    'select' => $table['authy'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['country'] = [
    'id_country' => [
        'type' => 'INTEGER',
    ],
    'name' => [
        'type' => 'VARCHAR',
        'description' => 'Name',
    ],
    'code' => [
        'type' => 'VARCHAR',
        'description' => 'Code',
    ],
    'timezone' => [
        'type' => 'VARCHAR',
        'description' => 'Timezone',
    ],
    'timezone_code' => [
        'type' => 'VARCHAR',
        'description' => 'Timezone code',
    ],
    'priority' => [
        'type' => 'INTEGER',
        'description' => 'Priority',
    ],
    'date_creation' => [
        'type' => 'TIMESTAMP',
    ],
    'date_modification' => [
        'type' => 'TIMESTAMP',
    ],
    'id_group_creation' => [
        'type' => 'INTEGER',
    ],
    'id_creation' => [
        'type' => 'INTEGER',
    ],
    'id_modification' => [
        'type' => 'INTEGER',
    ],
];

$query['country'] = [
    'select' => $table['country'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['asset'] = [
    'id_asset' => [
        'type' => 'INTEGER',
    ],
    'id_token' => [
        'type' => 'INTEGER',
        'description' => 'Token',
    ],
    'free_token' => [
        'type' => 'DECIMAL',
        'description' => 'Free',
    ],
    'staked_token' => [
        'type' => 'DECIMAL',
        'description' => 'Staked',
    ],
    'total_token' => [
        'type' => 'DECIMAL',
        'description' => 'Total',
    ],
    'usd_value' => [
        'type' => 'DECIMAL',
        'description' => 'Value USD',
    ],
    'locked_token' => [
        'type' => 'DECIMAL',
        'description' => 'Locked',
    ],
    'freeze_token' => [
        'type' => 'DECIMAL',
        'description' => 'Frozen',
    ],
    'last_sync' => [
        'type' => 'TIMESTAMP',
        'description' => 'Last sync',
    ],
    'date_creation' => [
        'type' => 'TIMESTAMP',
    ],
    'date_modification' => [
        'type' => 'TIMESTAMP',
    ],
    'id_group_creation' => [
        'type' => 'INTEGER',
    ],
    'id_creation' => [
        'type' => 'INTEGER',
    ],
    'id_modification' => [
        'type' => 'INTEGER',
    ],
];

$query['asset'] = [
    'select' => $table['asset'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['asset_exchange'] = [
    'id_asset_exchange' => [
        'type' => 'INTEGER',
    ],
    'id_asset' => [
        'type' => 'INTEGER',
    ],
    'type' => [
        'type' => 'ENUM',
        'description' => 'Type',
        'valueSet' => null,
    ],
    'id_exchange' => [
        'type' => 'INTEGER',
        'description' => 'Exchange',
    ],
    'id_token' => [
        'type' => 'INTEGER',
    ],
    'free_token' => [
        'type' => 'DECIMAL',
        'description' => 'Free',
    ],
    'locked_token' => [
        'type' => 'DECIMAL',
        'description' => 'Locked',
    ],
    'freeze_token' => [
        'type' => 'DECIMAL',
        'description' => 'Frozen',
    ],
    'date_creation' => [
        'type' => 'TIMESTAMP',
    ],
    'date_modification' => [
        'type' => 'TIMESTAMP',
    ],
    'id_group_creation' => [
        'type' => 'INTEGER',
    ],
    'id_creation' => [
        'type' => 'INTEGER',
    ],
    'id_modification' => [
        'type' => 'INTEGER',
    ],
];

$query['asset_exchange'] = [
    'select' => $table['asset_exchange'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['trade'] = [
    'id_trade' => [
        'type' => 'INTEGER',
    ],
    'type' => [
        'type' => 'ENUM',
        'description' => 'State',
        'valueSet' => null,
    ],
    'id_exchange' => [
        'type' => 'INTEGER',
        'description' => 'Exchange',
    ],
    'id_asset' => [
        'type' => 'INTEGER',
    ],
    'qty' => [
        'type' => 'DECIMAL',
        'description' => 'Qty',
    ],
    'id_symbol' => [
        'type' => 'INTEGER',
        'description' => 'Symbol',
    ],
    'date' => [
        'type' => 'TIMESTAMP',
        'description' => 'Date',
    ],
    'gross_usd' => [
        'type' => 'DECIMAL',
        'description' => 'Price',
    ],
    'commission' => [
        'type' => 'DECIMAL',
        'description' => 'Commission',
    ],
    'commission_asset' => [
        'type' => 'INTEGER',
        'description' => 'commissionAsset',
    ],
    'order_id' => [
        'type' => 'INTEGER',
    ],
    'date_creation' => [
        'type' => 'TIMESTAMP',
    ],
    'date_modification' => [
        'type' => 'TIMESTAMP',
    ],
    'id_group_creation' => [
        'type' => 'INTEGER',
    ],
    'id_creation' => [
        'type' => 'INTEGER',
    ],
    'id_modification' => [
        'type' => 'INTEGER',
    ],
];

$query['trade'] = [
    'select' => $table['trade'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['exchange'] = [
    'id_exchange' => [
        'type' => 'INTEGER',
    ],
    'name' => [
        'type' => 'VARCHAR',
        'description' => 'Name',
    ],
    'api_key' => [
        'type' => 'VARCHAR',
    ],
    'date_creation' => [
        'type' => 'TIMESTAMP',
    ],
    'date_modification' => [
        'type' => 'TIMESTAMP',
    ],
    'id_group_creation' => [
        'type' => 'INTEGER',
    ],
    'id_creation' => [
        'type' => 'INTEGER',
    ],
    'id_modification' => [
        'type' => 'INTEGER',
    ],
];

$query['exchange'] = [
    'select' => $table['exchange'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['token'] = [
    'id_token' => [
        'type' => 'INTEGER',
    ],
    'name' => [
        'type' => 'VARCHAR',
        'description' => 'Name',
    ],
    'ticker' => [
        'type' => 'VARCHAR',
        'description' => 'Ticker',
    ],
    'date_creation' => [
        'type' => 'TIMESTAMP',
    ],
    'date_modification' => [
        'type' => 'TIMESTAMP',
    ],
    'id_group_creation' => [
        'type' => 'INTEGER',
    ],
    'id_creation' => [
        'type' => 'INTEGER',
    ],
    'id_modification' => [
        'type' => 'INTEGER',
    ],
];

$query['token'] = [
    'select' => $table['token'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['symbol'] = [
    'id_symbol' => [
        'type' => 'INTEGER',
    ],
    'name' => [
        'type' => 'VARCHAR',
        'description' => 'Symbol',
    ],
    'id_token' => [
        'type' => 'INTEGER',
        'description' => 'Base Ticker',
    ],
    'date_creation' => [
        'type' => 'TIMESTAMP',
    ],
    'date_modification' => [
        'type' => 'TIMESTAMP',
    ],
    'id_group_creation' => [
        'type' => 'INTEGER',
    ],
    'id_creation' => [
        'type' => 'INTEGER',
    ],
    'id_modification' => [
        'type' => 'INTEGER',
    ],
];

$query['symbol'] = [
    'select' => $table['symbol'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['authy_group'] = [
    'id_authy_group' => [
        'type' => 'INTEGER',
    ],
    'name' => [
        'type' => 'VARCHAR',
        'description' => 'Name',
    ],
    'desc' => [
        'type' => 'VARCHAR',
        'description' => 'Description',
    ],
    'default_group' => [
        'type' => 'ENUM',
        'description' => 'Default',
        'valueSet' => null,
    ],
    'admin' => [
        'type' => 'ENUM',
        'description' => 'Admin',
        'valueSet' => null,
    ],
    'rights_all' => [
        'type' => 'VARCHAR',
        'description' => 'Rights',
    ],
    'rights_owner' => [
        'type' => 'VARCHAR',
        'description' => 'Rights owner',
    ],
    'rights_group' => [
        'type' => 'VARCHAR',
        'description' => 'Rights group',
    ],
    'date_creation' => [
        'type' => 'TIMESTAMP',
    ],
    'date_modification' => [
        'type' => 'TIMESTAMP',
    ],
    'id_group_creation' => [
        'type' => 'INTEGER',
    ],
    'id_creation' => [
        'type' => 'INTEGER',
    ],
    'id_modification' => [
        'type' => 'INTEGER',
    ],
];

$query['authy_group'] = [
    'select' => $table['authy_group'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['authy_group_x'] = [
    'id_authy' => [
        'type' => 'INTEGER',
    ],
    'id_authy_group' => [
        'type' => 'INTEGER',
        'description' => 'Group',
    ],
];

$query['authy_group_x'] = [
    'select' => $table['authy_group_x'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['authy_log'] = [
    'id_authy_log' => [
        'type' => 'INTEGER',
    ],
    'id_authy' => [
        'type' => 'INTEGER',
    ],
    'timestamp' => [
        'type' => 'TIMESTAMP',
        'description' => 'Date',
    ],
    'login' => [
        'type' => 'VARCHAR',
        'description' => 'Username',
    ],
    'userid' => [
        'type' => 'INTEGER',
    ],
    'result' => [
        'type' => 'VARCHAR',
    ],
    'ip' => [
        'type' => 'VARCHAR',
        'description' => 'Ip',
    ],
    'count' => [
        'type' => 'INTEGER',
        'description' => 'Count',
    ],
];

$query['authy_log'] = [
    'select' => $table['authy_log'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['message'] = [
    'id_message' => [
        'type' => 'INTEGER',
    ],
    'label' => [
        'type' => 'VARCHAR',
        'description' => 'Label',
    ],
];

$query['message'] = [
    'select' => $table['message'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['config'] = [
    'id_config' => [
        'type' => 'INTEGER',
    ],
    'category' => [
        'type' => 'ENUM',
        'description' => 'Category',
        'valueSet' => null,
    ],
    'config' => [
        'type' => 'VARCHAR',
        'description' => 'Setting',
    ],
    'value' => [
        'type' => 'LONGVARCHAR',
        'description' => 'Value',
    ],
    'system' => [
        'type' => 'ENUM',
    ],
    'description' => [
        'type' => 'VARCHAR',
        'description' => 'Description',
    ],
    'type' => [
        'type' => 'VARCHAR',
    ],
    'date_creation' => [
        'type' => 'TIMESTAMP',
    ],
    'date_modification' => [
        'type' => 'TIMESTAMP',
    ],
    'id_group_creation' => [
        'type' => 'INTEGER',
    ],
    'id_creation' => [
        'type' => 'INTEGER',
    ],
    'id_modification' => [
        'type' => 'INTEGER',
    ],
];

$query['config'] = [
    'select' => $table['config'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['api_rbac'] = [
    'id_api_rbac' => [
        'type' => 'INTEGER',
    ],
    'date_creation' => [
        'type' => 'DATE',
        'description' => 'Date',
    ],
    'description' => [
        'type' => 'LONGVARCHAR',
        'description' => 'Description',
    ],
    'model' => [
        'type' => 'VARCHAR',
        'description' => 'Model',
    ],
    'action' => [
        'type' => 'VARCHAR',
        'description' => 'Action',
    ],
    'body' => [
        'type' => 'LONGVARCHAR',
        'description' => 'Body',
    ],
    'query' => [
        'type' => 'LONGVARCHAR',
        'description' => 'Query',
    ],
    'method' => [
        'type' => 'ENUM',
        'description' => 'Method',
        'valueSet' => null,
    ],
    'scope' => [
        'type' => 'ENUM',
        'description' => 'Scope',
        'valueSet' => null,
    ],
    'rule' => [
        'type' => 'ENUM',
        'description' => 'Rule',
        'valueSet' => null,
    ],
    'count' => [
        'type' => 'INTEGER',
        'description' => 'Used count',
    ],
    'date_modification' => [
        'type' => 'TIMESTAMP',
    ],
    'id_group_creation' => [
        'type' => 'INTEGER',
    ],
    'id_creation' => [
        'type' => 'INTEGER',
    ],
    'id_modification' => [
        'type' => 'INTEGER',
    ],
];

$query['api_rbac'] = [
    'select' => $table['api_rbac'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['api_log'] = [
    'id_api_log' => [
        'type' => 'INTEGER',
    ],
    'id_api_rbac' => [
        'type' => 'INTEGER',
        'description' => 'Rule',
    ],
    'id_authy' => [
        'type' => 'INTEGER',
    ],
    'time' => [
        'type' => 'TIMESTAMP',
        'description' => 'Time',
    ],
];

$query['api_log'] = [
    'select' => $table['api_log'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['template'] = [
    'id_template' => [
        'type' => 'INTEGER',
    ],
    'name' => [
        'type' => 'VARCHAR',
        'description' => 'Name',
    ],
    'subject' => [
        'type' => 'VARCHAR',
        'description' => 'Subject',
    ],
    'color_1' => [
        'type' => 'VARCHAR',
        'description' => 'Color 1',
    ],
    'color_2' => [
        'type' => 'VARCHAR',
        'description' => 'Color 2',
    ],
    'color_3' => [
        'type' => 'VARCHAR',
        'description' => 'Color 3',
    ],
    'status' => [
        'type' => 'ENUM',
        'description' => 'Status',
        'valueSet' => null,
    ],
    'body' => [
        'type' => 'LONGVARCHAR',
        'description' => 'Body',
    ],
    'date_creation' => [
        'type' => 'TIMESTAMP',
    ],
    'date_modification' => [
        'type' => 'TIMESTAMP',
    ],
    'id_group_creation' => [
        'type' => 'INTEGER',
    ],
    'id_creation' => [
        'type' => 'INTEGER',
    ],
    'id_modification' => [
        'type' => 'INTEGER',
    ],
];

$query['template'] = [
    'select' => $table['template'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['template_file'] = [
    'id_template_file' => [
        'type' => 'INTEGER',
    ],
    'id_template' => [
        'type' => 'INTEGER',
    ],
    'name' => [
        'type' => 'VARCHAR',
        'description' => 'Name',
    ],
    'file' => [
        'type' => 'VARCHAR',
        'description' => 'File',
    ],
    'date_creation' => [
        'type' => 'TIMESTAMP',
    ],
    'date_modification' => [
        'type' => 'TIMESTAMP',
    ],
    'id_group_creation' => [
        'type' => 'INTEGER',
    ],
    'id_creation' => [
        'type' => 'INTEGER',
    ],
    'id_modification' => [
        'type' => 'INTEGER',
    ],
];

$query['template_file'] = [
    'select' => $table['template_file'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];
$table['message_i18n'] = [
    'id_message' => [
        'type' => 'INTEGER',
    ],
    'locale' => [
        'type' => 'VARCHAR',
    ],
    'text' => [
        'type' => 'LONGVARCHAR',
        'description' => 'Texte',
    ],
    'date_creation' => [
        'type' => 'TIMESTAMP',
    ],
    'date_modification' => [
        'type' => 'TIMESTAMP',
    ],
    'id_group_creation' => [
        'type' => 'INTEGER',
    ],
    'id_creation' => [
        'type' => 'INTEGER',
    ],
    'id_modification' => [
        'type' => 'INTEGER',
    ],
];

$query['message_i18n'] = [
    'select' => $table['message_i18n'],
    'filter' => [],
    'join' => [],
    'limit' => [],
    'order' => [],
    'page' => [],
];

return [
            'Authy/auth' => [
            'description' => "Authenticate a user and get a JWT token.",
            'type' => 'service',
            'POST' => [
                'request' => [
                            'u' => ['type' => 'string',
                                    'description'=> 'Username'
                            ],
                            'pw' => ['type' => 'string',
                                    'description'=> 'The MD5 hash of the password.'
                            ],
                ],
                'response' => [
                    'token' => ['type' => 'string',
                                'description'=> 'The JWT tocken.'
                    ],
                    'expires' => ['type' => 'timestamp',
                                'description'=> 'The expiration datetime.'
                    ],
                ]
            ]
        ],
        'ApiGoat/sendEmail' => [
            'description' => "Send an email to one or multiple existing email address(es).",
            'type' => 'service',
            'POST' => [
                'request' => [
                    'template_name' => ['type' => 'string',
                                        'description'=> 'The name of an existing template.'
                    ],
                    'email' => ['type' => 'string',
                                        'description'=> 'An existing email from the the Authy table.'
                    ],
                ],
                'response' => [
                    'data' => 'null',
                    'messages' => ['type' => 'string',
                                'description'=> 'The status of the email sender.'
                    ]
                ]
            ]
        ],
        'ApiGoat/account/{id}' => [
            'description' => "Get an account details.",
            'type' => 'service',
            'GET' => [
                'request' => [
                    'id' => ['type' => 'integer',
                            'description'=> 'A Authy id.'
                    ]
                ],
                'response' => [
                    'data' => ['type' => 'array',
                                'description'=> 'All Authy fields minus the secured ones (password, rights, etc...).'
                    ],
                ]
            ]
        ],
        'ApiGoat/reset/{key}' => [
            'description' => "Reset a password from a one time key.",
            'type' => 'service',
            'POST' => [
                'request' => [
                    'key' => ['type' => 'string',
                                        'description'=> 'The name of an existing template.'
                    ],
                    'email' => ['type' => 'string',
                                        'description'=> 'An existing email from the the Authy table.'
                    ],
                ],
                'response' => [
                    'data' => ['type' => 'string',
                                'description'=> 'The status of the email sender.'
                    ],
                ]
            ]
        ],
        'ApiGoat/oAuth/{Provider}/' => [
            'description' => "Use Oauth service to register and connect your user. The service must have been configured separatly beforehand.",
            'type' => 'service',
            'GET' => [
                'request' => [
                    'Provider' => ['type' => 'string',
                                    'description'=> 'One of the supported provider [facebook, github].'],
                ],
                'response' => [
                    'description' => "Redirection to the provider."
                ]
            ]
        ],
    'authy[/{id}]' => [
        'description' => 'User',
        'type' => 'base',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_authy'
                ]
            ],
            'response' => [
                'data' => $table['authy']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['authy'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['authy']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_authy'
            ]
        ],
    ],
    'country[/{id}]' => [
        'description' => 'Country',
        'type' => 'custom',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_country'
                ]
            ],
            'response' => [
                'data' => $table['country']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['country'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['country']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_country'
            ]
        ],
    ],
    'asset[/{id}]' => [
        'description' => 'Asset',
        'type' => 'custom',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_asset'
                ]
            ],
            'response' => [
                'data' => $table['asset']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['asset'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['asset']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_asset'
            ]
        ],
    ],
    'asset_exchange[/{id}]' => [
        'description' => 'Wallet',
        'type' => 'custom',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_asset_exchange'
                ]
            ],
            'response' => [
                'data' => $table['asset_exchange']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['asset_exchange'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['asset_exchange']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_asset_exchange'
            ]
        ],
    ],
    'trade[/{id}]' => [
        'description' => 'Trade',
        'type' => 'custom',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_trade'
                ]
            ],
            'response' => [
                'data' => $table['trade']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['trade'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['trade']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_trade'
            ]
        ],
    ],
    'exchange[/{id}]' => [
        'description' => 'Exchange',
        'type' => 'custom',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_exchange'
                ]
            ],
            'response' => [
                'data' => $table['exchange']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['exchange'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['exchange']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_exchange'
            ]
        ],
    ],
    'token[/{id}]' => [
        'description' => 'Token',
        'type' => 'custom',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_token'
                ]
            ],
            'response' => [
                'data' => $table['token']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['token'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['token']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_token'
            ]
        ],
    ],
    'symbol[/{id}]' => [
        'description' => 'Symbol',
        'type' => 'custom',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_symbol'
                ]
            ],
            'response' => [
                'data' => $table['symbol']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['symbol'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['symbol']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_symbol'
            ]
        ],
    ],
    'authy_group[/{id}]' => [
        'description' => 'Group',
        'type' => 'base',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_authy_group'
                ]
            ],
            'response' => [
                'data' => $table['authy_group']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['authy_group'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['authy_group']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_authy_group'
            ]
        ],
    ],
    'authy_group_x[/{id}]' => [
        'description' => 'Group',
        'type' => 'base',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_authy_group'
                ]
            ],
            'response' => [
                'data' => $table['authy_group_x']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['authy_group_x'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['authy_group_x']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_authy_group'
            ]
        ],
    ],
    'authy_log[/{id}]' => [
        'description' => 'Login log',
        'type' => 'base',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_authy_log'
                ]
            ],
            'response' => [
                'data' => $table['authy_log']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['authy_log'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['authy_log']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_authy_log'
            ]
        ],
    ],
    'message[/{id}]' => [
        'description' => 'Message',
        'type' => 'base',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_message'
                ]
            ],
            'response' => [
                'data' => $table['message']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['message'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['message']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_message'
            ]
        ],
    ],
    'config[/{id}]' => [
        'description' => 'Setting',
        'type' => 'base',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_config'
                ]
            ],
            'response' => [
                'data' => $table['config']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['config'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['config']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_config'
            ]
        ],
    ],
    'api_rbac[/{id}]' => [
        'description' => 'API ACL',
        'type' => 'base',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_api_rbac'
                ]
            ],
            'response' => [
                'data' => $table['api_rbac']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['api_rbac'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['api_rbac']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_api_rbac'
            ]
        ],
    ],
    'api_log[/{id}]' => [
        'description' => 'API log',
        'type' => 'base',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_api_log'
                ]
            ],
            'response' => [
                'data' => $table['api_log']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['api_log'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['api_log']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_api_log'
            ]
        ],
    ],
    'template[/{id}]' => [
        'description' => 'Template',
        'type' => 'base',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_template'
                ]
            ],
            'response' => [
                'data' => $table['template']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['template'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['template']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_template'
            ]
        ],
    ],
    'template_file[/{id}]' => [
        'description' => 'File',
        'type' => 'base',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_template_file'
                ]
            ],
            'response' => [
                'data' => $table['template_file']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['template_file'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['template_file']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_template_file'
            ]
        ],
    ],
    'message_i18n[/{id}]' => [
        'description' => '',
        'type' => 'base',
        'GET' => [
            'request' => [
                'id' => [
                    'type' => 'INTEGER',
                    'name' => 'id_template_file'
                ]
            ],
            'response' => [
                'data' => $table['message_i18n']
            ]
        ],
        'POST' =>  [
            'request' => [
                'fields' => $table['message_i18n'],
                'query' => $query
            ],
            'response' => [
                'ids' => [],
                'count' => []
            ]
        ],
        'PATCH' =>  [
            'request' => $table['message_i18n']
            ],
        'DELETE' =>  [
            'request' => [
                        'type' => 'INTEGER',
                        'name' => 'id_template_file'
            ]
        ],
    ],
];
