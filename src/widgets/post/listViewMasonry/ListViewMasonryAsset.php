<?php

namespace omny\yii2\blog\module\widgets\post\listViewMasonry;

use yii\web\AssetBundle;

/**
 * Class ListViewMasonryAsset
 * @package omny\yii2\blog\module\widgets\post\listViewMasonry
 */
class ListViewMasonryAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = '@vendor/omny/yii2-blog-module/src/widgets/post/listViewMasonry/assets';

    /** @var array */
    public $css = [
        'css/first_articles_style.css',
    ];
}
