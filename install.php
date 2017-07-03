<?php

if (!file_exists('.env')) {
    exit(".env file is missing\n");
}

require 'vendor/autoload.php';

(new \Dotenv\Dotenv(__DIR__))->load();

$name = getenv('DB_NAME');
$propel = [
    'propel' => [
        'database' => [
            'connections' => [
                $name => [
                    'adapter'    => 'mysql',
                    'classname'  => 'Propel\Runtime\Connection\ConnectionWrapper',
                    'dsn'        => 'mysql:host=' . getenv('DB_HOST') .';dbname=' . getenv('DB_NAME') . ';charset=utf8',
                    'user'       => getenv('DB_USER'),
                    'password'   => getenv('DB_PASS'),
                    'attributes' => []
                ]
            ]
        ],
        'runtime' => [
            'defaultConnection' => $name,
            'connections'       => [$name]
        ],
        'generator' => [
            'defaultConnection' => $name,
            'connections'       => [$name],
            'dateTime' => [
                'defaultTimeStampFormat' => 'Y-m-d H:i:s',
                'defaultTimeFormat'      => 'H:i:s',
                'defaultDateFormat'      => 'Y-m-d'
            ]
        ]
    ]
];

file_put_contents('config/propel.php', "<?php\nreturn " . var_export($propel, true) . ';');

// exec('php vendor/bin/propel model:build --schema-dir ./config --output-dir ./src --config-dir ./config -vv');
// exec('php vendor/bin/propel sql:build --config-dir ./config --schema-dir ./config');