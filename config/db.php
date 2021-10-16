<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=invest_db_prod;dbname=investimento',
    'username' => 'postgres',
    'password' => 'postgres',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
