<?php
//多游戏数据库配置
return [
    'dbConfig' => [
        'ares' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=test',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
        ],
        'crius' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=walleui',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
        ],
        'saiya' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=walle_test',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
        ],
        'icx' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=walle_dev',
            'username' => 'walle',
            'password' => 'wW#3HdCDp&9r',
            'charset' => 'utf8',
        ],
        'war' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=walle_dev_war',
            'username' => 'walle',
            'password' => 'wW#3HdCDp&9r',
            'charset' => 'utf8',
        ],
        'master' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=walle_dev_master',
            'username' => 'walle',
            'password' => 'wW#3HdCDp&9r',
            'charset' => 'utf8',
        ],
        'xianpro' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=walle_dev_xianpro',
            'username' => 'walle',
            'password' => 'wW#3HdCDp&9r',
            'charset' => 'utf8',
        ],
    ]
];

