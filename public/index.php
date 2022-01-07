<?php

require __DIR__ . '/../vendor/autoload.php'; // 引入 Composer 自动加载器
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php'; // 引入 Yii 自动加载器

/**
 * 注册路径别名，实现：
 * 1）可通过 `Yii::getAlias()` 方法将包含别名 `@mini` 的路径转换为绝对路径
 * 2）在 `src` 目录下自动加载命名空间为 `mini\*` 的类
 */
Yii::setAlias('@mini', dirname(__DIR__).'/src');

/**
 * id和basePath是实例化Application类的必须参数
 * @see http://www.yiiframework.com/doc-2.0/guide-structure-applications.html#required-properties
 */
$config = [
    'id' => 'yii2-mini',
    'basePath' => dirname(__DIR__),
    // 告诉框架，控制器在哪里
    'controllerNamespace' => 'mini\controllers',
    // 在 Application 的 bootstrap() 方法里初始化的组件
    'bootstrap' => ['log'],
    // 组件列表
    'components' => [
        // 添加日志组件
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget', // 文件日志
                    'levels' => ['error', 'warning'], // 日志级别
                ],
            ],
        ],
    ],
];

(new yii\web\Application($config))->run();
