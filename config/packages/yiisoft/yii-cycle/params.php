<?php

declare(strict_types=1);

use Cycle\Schema\Generator;
use Cycle\ORM\PromiseFactoryInterface;
use Spiral\Database\Driver\SQLite\SQLiteDriver;
use Yiisoft\Yii\Cycle\Command\Schema;
use Yiisoft\Yii\Cycle\Command\Migration;
use Yiisoft\Yii\Cycle\Schema\Provider\FromConveyorSchemaProvider;
use Yiisoft\Yii\Cycle\Schema\SchemaProviderInterface;

return [
    // Console commands
    'yiisoft/yii-console' => [
        'commands' => [
            'cycle/schema' => Schema\SchemaCommand::class,
            'cycle/schema/php' => Schema\SchemaPhpCommand::class,
            'cycle/schema/clear' => Schema\SchemaClearCommand::class,
            'cycle/schema/rebuild' => Schema\SchemaRebuildCommand::class,
            'migrate/create' => Migration\CreateCommand::class,
            'migrate/generate' => Migration\GenerateCommand::class,
            'migrate/up' => Migration\UpCommand::class,
            'migrate/down' => Migration\DownCommand::class,
            'migrate/list' => Migration\ListCommand::class,
        ],
    ],

    'yiisoft/yii-cycle' => [
        // DBAL config
        'dbal' => [
            // SQL query logger. Definition of Psr\Log\LoggerInterface
            'query-logger' => null,
            // Default database
            'default' => 'default',
            'aliases' => [],
            'databases' => [
                'default' => ['connection' => 'sqlite'],
            ],
            'connections' => [
                'sqlite' => [
                    'driver' => SQLiteDriver::class,
                    'connection' => $_ENV['YII_ENV'] === 'production'
                        ? 'sqlite:@data/db/database.db'
                        : 'sqlite:@tests/_data/database.db',
                    'username' => '',
                    'password' => '',
                ],
            ],
        ],

        // Cycle migration config
        'migrations' => [
            'directory' => '@root/migrations',
            'namespace' => 'App\\Migration',
            'table' => 'migration',
            'safe' => false,
        ],

        /**
         * Config for {@see \Yiisoft\Yii\Cycle\Factory\OrmFactory}
         * Null, classname or {@see PromiseFactoryInterface} object.
         *
         * @link https://github.com/cycle/docs/blob/master/advanced/promise.md
         */
        'orm-promise-factory' => null,

        /**
         * SchemaProvider list for {@see \Yiisoft\Yii\Cycle\Schema\Provider\Support\SchemaProviderPipeline}
         * Array of classname and {@see SchemaProviderInterface} object.
         * You can configure providers if you pass classname as key and parameters as array:
         * [
         *     SimpleCacheSchemaProvider::class => [
         *         'key' => 'my-custom-cache-key'
         *     ],
         *     FromFilesSchemaProvider::class => [
         *         'files' => ['@runtime/cycle-schema.php']
         *     ],
         *     FromConveyorSchemaProvider::class => [
         *         'generators' => [
         *              Generator\SyncTables::class, // sync table changes to database
         *          ]
         *     ],
         * ]
         */
        'schema-providers' => [
            // Uncomment next line to enable schema cache
            // SimpleCacheSchemaProvider::class => ['key' => 'cycle-orm-cache-key'],
            FromConveyorSchemaProvider::class => [
                'generators' => [
                    Generator\SyncTables::class,
                ],
            ],
        ],

        /**
         * Config for {@see \Yiisoft\Yii\Cycle\Schema\Conveyor\AnnotatedSchemaConveyor}
         * Annotated entity directories list.
         * {@see \Yiisoft\Aliases\Aliases} are also supported.
         */
        'annotated-entity-paths' => [
            '@src',
        ],
    ],
];
