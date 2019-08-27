<?php

use omny\yii2\blog\module\models\Img;
use omny\yii2\blog\module\models\Post;

/**
 * @var $this yii\web\View
 * @var Post $model
 * @var Img $imgModel
 */

$this->title = 'Create Post';
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">
    <?= $this->render('_form', compact('model', 'imgModel')) ?>
</div>