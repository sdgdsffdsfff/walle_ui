<?php

return [
    'adminEmail' => 'admin@example.com',
    //左侧菜单
    'menuData' => [
        [
            'name' => '首页',
            'path' => 'index/index',
            'icon' => 'fa-home',
        ],
        [
            'name' => '版本列表',
            'path' => 'version/list',
            'icon' => 'fa-list',
        ],
        [
            'name' => '创建版本',
            'path' => 'version/add-version',
            'icon' => 'pe-7s-news-paper',
        ],
        [
            'name' => '创建发布任务',
            'path' => 'task/publish',
            'icon' => 'fa-volume-up',
        ],
        [
            'name' => '发布任务列表',
            'path' => 'task/list',
            'icon' => 'fa-list-alt',
        ],
        [
            'name' => '安装包下载',
            'path' => 'clientpackage/list',
            'icon' => 'fa-cloud-download',
        ],
        [
            'name' => '更新模块版本列表',
            'path' => 'module/index',
            'icon' => 'fa-stack-exchange',
        ]
    ],
];
