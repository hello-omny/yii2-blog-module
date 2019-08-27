<?php

namespace omny\yii2\blog\module\assets;

use yii\web\AssetBundle;

/**
 * Class BlogModuleBackendAsset
 * @package omny\yii2\blog\module\assets
 */
class BlogModuleBackendAsset extends AssetBundle
{
    /** @var string */
//    public $basePath = "@vendor/omny/yii2-blog-module/src/resources/backend/";

    public $sourcePath = "@vendor/omny/yii2-blog-module/src/resources/backend/";

    /** @var array */
    public $css = [
        'css/backend.css'
    ];

    /** @var array */
    public $depends = [
        BlogModuleAsset::class
    ];
}