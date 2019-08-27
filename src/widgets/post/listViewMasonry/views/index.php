<?php

/**
 * @var View $this
 * @var ActiveDataProvider $provider
 * @var array $layout
 * @var int $limit
 */

use omny\yii2\blog\module\widgets\post\listViewMasonry\ListViewMasonryAsset;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;

ListViewMasonryAsset::register($this);

echo ListView::widget([
    'summary' => false,
    'dataProvider' => $provider,
    'itemView' => '_item',
    "viewParams" => [
        'layout' => $layout,
        'pagination' => $provider->getPagination(),
        'provider' => $provider,
    ],
    'itemOptions' => [
        'tag' => false,
    ],
    'options' => [
        'tag' => false,
    ]
]);
