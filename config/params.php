<?php

return [
    'scriptPath' => '/data/work/walle/walle3/env/bin/',
    'adminEmail' => 'admin@example.com',
    //左侧菜单
    'menuData' => [
        [
            'name' => '首页',
            'path' => '/index/index',
            'icon' => 'fa-home',
        ],
        [
            'name' => '版本管理',
            'controller' => 'version',
            'path' => 'javascript:void(0);',
            'icon' => 'fa-list',
            'subMenu' => [
                [
                    'name' => '版本列表',
                    'path' => 'version/list',
                ],
                [
                    'name' => '创建版本',
                    'path' => 'version/add-version',
                ],
                [
                    'name' => '版本对比',
                    'path' => 'version/compare',
                ],
            ],
        ],
        [
            'name' => '任务管理',
            'controller' => 'task, parameter',
            'path' => 'javascript:void(0);',
            'icon' => 'fa-list-alt',
            'subMenu' => [
                [
                    'name' => '发布任务列表',
                    'path' => 'task/list',
                ],
                [
                    'name' => '创建发布任务',
                    'path' => 'task/publish',
                ],
                [
                    'name' => '发布任务对比',
                    'path' => 'task/compare',
                ],
                [
                    'name' => '参数配置(parameter)',
                    'path' => 'parameter/list',
                ],
                [
                    'name' => '动态参数配置',
                    'path' => 'parameter/dynamic-config',
                ],
            ],
        ],
        [
            'name' => '业务模块管理',
            'controller' => 'module',
            'path' => 'javascript:void(0);',
            'icon' => 'fa-cube',
            'subMenu' => [
                [
                    'name' => '安装包下载',
                    'path' => 'clientpackage/list',
                ],
                [
                    'name' => '客户端更新包状态',
                    'path' => 'clientpackage/liststatus',
                ],
                [
                    'name' => '安装包列表',
                    'path' => 'package/list',
                    'name' => '业务模块配置(module)',
                    'path' => 'module/list',
                ],
                [
                    'name' => '更新模块版本列表',
                    'path' => 'module/index',
                ],
            ],
        ],
        [
            'name' => '升级序列管理',
            'controller' => 'upgradepath',
            'path' => 'javascript:void(0);',
            'icon' => 'fa-cloud-upload',
            'subMenu' => [
                [
                    'name' => '升级序列列表',
                    'path' => 'upgradepath/list',
                ],
                [
                    'name' => '升级序列配置',
                    'path' => '',
                ],
            ],
        ],
        [
            'name' => '发行地区管理',
            'controller' => 'region',
            'path' => 'javascript:void(0);',
            'icon' => 'fa-globe',
            'subMenu' => [
                [
                    'name' => '发行地区列表',
                    'path' => 'region/list',
                ],
                [
                    'name' => '发行地区配置',
                    'path' => 'region/config-list',
                ],
            ],
        ],
        [
            'name' => '平台管理',
            'controller' => 'platform',
            'path' => 'javascript:void(0);',
            'icon' => 'fa-desktop',
            'subMenu' => [
                [
                    'name' => '平台信息列表',
                    'path' => 'platform/list',
                ],
                [
                    'name' => '平台信息配置',
                    'path' => '',
                ],
            ],
        ],
        [
            'name' => '部署位置管理',
            'controller' => 'deployment',
            'path' => 'javascript:void(0);',
            'icon' => 'fa-map-marker',
            'subMenu' => [
                [
                    'name' => '部署位置列表',
                    'path' => 'deplayment/list',
                ],
                [
                    'name' => '部署位置配置',
                    'path' => '',
                ],
            ],
        ],
        [
            'name' => '安装包管理',
            'controller' => 'clientpackage',
            'path' => 'javascript:void(0);',
            'icon' => 'fa-suitcase',
            'subMenu' => [
                [
                    'name' => '安装包下载',
                    'path' => 'clientpackage/list',
                ],
                [
                    'name' => '客户端更新包状态',
                    'path' => '',
                ],
                [
                    'name' => '安装包列表',
                    'path' => '',
                ],
                [
                    'name' => '安装包配置',
                    'path' => 'clientpackage/package-config-list',
                ],
            ],
        ],
        [
            'name' => '打包机管理',
            'controller' => 'worker',
            'path' => '/worker/list',
            'icon' => 'fa-folder',
        ],
    ],
];
