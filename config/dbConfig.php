<?php
//多游戏数据库配置
return [
    'dbConfig' => [
        'ares' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=mostsdk',
            'username' => 'root',
            'password' => '111111',
            'charset' => 'utf8',
        ],
        'crius' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=walle',
            'username' => 'root',
            'password' => '111111',
            'charset' => 'utf8',
        ],
    ]
];

