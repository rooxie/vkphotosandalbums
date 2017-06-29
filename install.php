<?php

if (!file_exists('.env')) {
    exit(".env file is missing\n");
}

exec('composer install');

require 'vendor/autoload.php';

(new \Dotenv\Dotenv(__DIR__))->load();

$propel = [
    'propel' => [
        'database' => [
            'connections' => [
                getenv('APP_NAME') => [
                    'adapter'    => getenv('ADAPTER') ,
                    'classname'  => 'Propel\Runtime\Connection\ConnectionWrapper',
                    'dsn'        => getenv('ADAPTER') . ':host=' . getenv('DB_HOST') .';dbname=' . getenv('DB_NAME') . ';charset=utf8',
                    'user'       => getenv('DB_USER'),
                    'password'   => getenv('DB_PASS'),
                    'attributes' => []
                ]
            ]
        ],
        'runtime' => [
            'defaultConnection' => getenv('APP_NAME'),
            'connections'       => [getenv('APP_NAME')]
        ],
        'generator' => [
            'defaultConnection' => getenv('APP_NAME'),
            'connections'       => [getenv('APP_NAME')],
            'dateTime' => [
                'defaultTimeStampFormat' => 'Y-m-d H:i:s',
                'defaultTimeFormat'      => 'H:i:s',
                'defaultDateFormat'      => 'Y-m-d'
            ]
        ]
    ]
];

file_put_contents('config/propel.php', "<?php\nreturn " . var_export($propel, true) . ';');

exec('php vendor/bin/propel model:build --schema-dir ./config --output-dir ./src --config-dir ./config -vv');