<?php

return [
    'scriptPath' => '/data/work/walle/walle3/env/bin/',
    'uploadPath' => 'http://rc.walle.playcrab-inc.com/walle/package/',
    'adminEmail' => 'admin@example.com',
    //左侧菜单
    'menuData' => [
        [
            'name' => '首页',
            'path' => 'index/index',
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
                    'path' => ['version/list','version/version-detail'],
                ],
                [
                    'name' => '创建版本',
                    'path' => ['version/add-version'],
                ],
                [
                    'name' => '版本对比',
                    'path' => ['version/compare'],
                ],
            ],
        ],
        [
            'name' => '任务管理',
            'controller' => 'task',
            'path' => 'javascript:void(0);',
            'icon' => 'fa-list-alt',
            'subMenu' => [
                [
                    'name' => '发布任务列表',
                    'path' => ['task/list','task/detail'],
                ],
                [
                    'name' => '创建发布任务',
                    'path' => ['task/publish', 'task/clonepublish'],
                ],
                [
                    'name' => '发布任务对比',
                    'path' => ['task/compare', 'task/compare-detail'],
                ],
            ],
        ],
        [
            'name' => '安装包下载',
            'controller' => 'clientpackage',
            'path' => 'clientpackage/list',
            'icon' => 'fa-cloud-download',
        ],
        [
            'name' => '客户端更新包状态',
            'controller' => 'packagestatus',
            'path' => 'packagestatus/list',
            'icon' => 'fa-cloud-download',
        ],
        [
            'name' => '更新模块版本列表',
            'controller' => 'module',
            'path' => 'module/index',
            'icon' => 'fa-puzzle-piece',
        ],
        [
            'name' => '基础信息配置',
            'controller' => 'parameter,upgradepath,region,platform,deployment,worker,business,package',
            'path' => 'javascript:void(0);',
            'icon' => 'fa-cogs',
            'subMenu' => [
                [
                    'name' => '参数配置(parameter)',
                    'path' => ['parameter/list','parameter/edit','parameter/create']
                ],
                [
                    'name' => '动态参数配置',
                    'path' => ['parameter/dynamic-config','parameter/dynamic-config-edit']
                ],
                [
                    'name' => '业务模块配置(module)',
                    'path' => ['business/list','business/edit','business/create']
                ],
                [
                    'name' => '升级序列列表',
                    'path' => ['upgradepath/list','upgradepath/edit','upgradepath/copy']
                ],
                [
                    'name' => '升级序列配置',
                    'path' => ['upgradepath/config-list','upgradepath/config-create','upgradepath/config-edit']
                ],
                [
                    'name' => '发行地区列表',
                    'path' => ['region/list','region/edit']
                ],
                [
                    'name' => '发行地区配置',
                    'path' => ['region/config-list','region/config-edit']
                ],
                [
                    'name' => '平台信息列表',
                    'path' => ['platform/list','platform/edit']
                ],
                [
                    'name' => '平台信息配置',
                    'path' => ['platform/config-list','platform/config-edit']
                ],
                [
                    'name' => '部署位置列表',
                    'path' => ['deployment/list','deployment/edit']
                ],
                [
                    'name' => '部署位置配置',
                    'path' => ['deployment/config-list','deployment/config-edit']
                ],
                [
                    'name' => '安装包列表',
                    'path' => ['package/tolist','package/edit']
                ],
                [
                    'name' => '安装包配置',
                    'path' => ['package/config-list','package/config-edit']
                ],
                [
                    'name' => '打包机列表',
                    'path' => ['worker/list','worker/edit','worker/create']
                ]
            ]
        ],
    ],
];
