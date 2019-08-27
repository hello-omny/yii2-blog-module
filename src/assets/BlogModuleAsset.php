<?php

namespace omny\yii2\blog\module\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;

/**
 * Class BlogModuleAsset
 * @package omny\yii2\blog\module\assets
 */
class BlogModuleAsset extends AssetBundle
{
    /** @var string */
    public $basePath = "@vendor/omny/yii2-blog-module/src/resources/common";
    /** @var array */
    public $depends = [
        BootstrapAsset::class
    ];
}
