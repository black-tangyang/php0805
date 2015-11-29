<?php
return array(
    //'配置项'=>'配置值'
    'DB_TYPE' => 'mysql',     // 数据库类型
    'DB_HOST' => '127.0.0.1', // 服务器地址
    'DB_NAME' => 'shop',          // 数据库名
    'DB_USER' => 'root',      // 用户名
    'DB_PWD' => '123456',          // 密码
    'DB_PORT' => '3306',        // 端口
    'DB_PREFIX' => '',    // 数据库表前缀

    /**
     * 使用redis作为缓存的软件
     */
    'DATA_CACHE_TYPE' => 'Redis', // 数据缓存类型,支持:File|Db|Apc|Memcache|Shmop|Sqlite|Xcache|Apachenote|Eaccelerator
    'REDIS_HOST' => '127.0.0.1',
    'REDIS_PORT' => 6379,
    'DATA_CACHE_PREFIX' => 'itsource_',

    'MAIL_CONFIG' => array(
        'Host' => 'smtp.126.com',                    // 设置邮件的服务器
        'Username' => 'itsource520@126.com',              // 登陆用户的用户名
        'Password' => 'qqitsource520',
        'From' => 'itsource520@126.com',
    ),

    /**
     * 静态缓存开启
     */
    'HTML_CACHE_ON' => true, // 开启静态缓存
    'HTML_CACHE_TIME' => 60,   // 全局静态缓存有效期（秒）
    'HTML_FILE_SUFFIX' => '.shtml', // 设置静态缓存文件后缀
    'HTML_CACHE_RULES' => array(  // 定义静态缓存规则
        // 定义格式1 数组方式
        'Index:index' => array('index', 60 * 60 * 24),
        'Index:show' => array('Goods/{id}', 60 * 60 * 24),
    ),
);