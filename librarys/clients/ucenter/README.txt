├── README
├── autoload.php             (自动加载器)
├── config.inc.php           (配置文件)
├── demo                     (示例文件)
│   ├── examples             (综合示例）
│   │   ├── code
│   │   │   ├── login.php
│   │   │   ├── login_callback.php
│   │   │   └── logout.php
│   │   └── index.php
│   └── sample.php           (接口示例)
├── docs
├── lib
│   ├── Base.php
│   ├── Client.php
│   ├── Config.php
│   ├── Exception.php
│   ├── HttpClient.php
│   └── Logger.php
├── logs                     (日志文件夹)
│  
├── services                 (服务文件夹)
│   ├── Common.php
│   ├── Game.php
│   ├── Platform.php
│   └── User.php
│ 
└── util                     (工具文件夹）
    ├── Encoding.php
    ├── Func.php
    └── MimeTypes.php

版本: Ucenter-Sdk-1.0.3-release

针对人群：
    玩蟹内部WEB项目开发者

注意事项:
    1.使用者需修改配置文件，填写正确的API访问地址， 以及项目API_KEY, 项目秘钥API_SECRET
    2.API_KEY, API_SECRET需从Ucenter后台获取
    3.请为日志目录设置可写权限

示例DEMO, NGINX虚拟主机配置:
    server {
        listen       80;
        server_name  www.domain2.com;
        root  /path/clients/ucenter/demo/examples;
        location / {
            index  index.php index.html index.htm;
        }

        access_log  logs/domain2-access.log  main;

        location ~ \.php$ {
            include fastcgi.conf;
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            expires off;
         }
     }

ChangeLog:
   1.增加相关PROJECTAPI接口
    getRoles getFunctions getUsers get Admins