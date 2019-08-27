<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveDataProvider $provider
 */

$this->title = 'Черновики';
$this->params['breadcrumbs'][] = ['label' => 'Блог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'id',
        'title',
        'category.title',
        'status',
        'created',
        [
            'class' => \yii\grid\ActionColumn::class
        ]
    ]
]);
