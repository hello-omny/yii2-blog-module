<?php

use omny\yii2\blog\module\models\Post;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var yii\web\View $this */
/* @var Post $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= $model->body ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'slug',
            'category.title',
            'status',
            'updated',
            'created',
        ],
    ]) ?>
</div>
