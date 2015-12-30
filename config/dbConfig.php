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
    ]
];

