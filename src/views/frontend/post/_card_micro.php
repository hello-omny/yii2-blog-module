<?php

use yii\helpers\Url;
use yii\bootstrap\Html;

/**
 * @var $this \yii\web\View
 * @var $model \app\modules\blog\models\Post
 */

$link = Url::toRoute(['/blog/post/view', 'slug' => $model->slug]);
?>
<div class="title">
    <a href="<?= $link ?>"><?= Html::encode($model->title) ?></a>
    <span class="date"><?= Yii::$app->formatter->asDate($model->publish_at, 'long') ?></span>
</div>