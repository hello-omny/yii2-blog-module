<?php

namespace omny\yii2\blog\module;

use yii\base\Module;

/**
 * Class BackendModule
 * @package omny\yii2\blog\module
 */
class BackendModule extends Module
{
    /** @var string */
    public $controllerNamespace = 'omny\yii2\blog\module\controllers\backend';
    /** @var string */
    public $layout = 'main';
    /** @var string */
//    public $viewPath = '@vendor/omny/yii2-blog-module/src/views/backend/';
}
