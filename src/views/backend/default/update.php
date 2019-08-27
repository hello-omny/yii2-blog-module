<?php

use omny\yii2\blog\module\models\Img;
use omny\yii2\blog\module\models\Post;

/**
 * @var $this yii\web\View
 * @var Post $model
 * @var Img $imgModel
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-update">
    <?= $this->render('_form', compact('model', 'imgModel')) ?>
</div>