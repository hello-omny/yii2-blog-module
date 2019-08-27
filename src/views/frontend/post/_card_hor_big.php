<?php

use yii\helpers\Url;
use yii\bootstrap\Html;
use app\modules\image\models\Img;
use app\modules\blog\widgets\PostMeta\PostMetaWidget;

/**
 * @var $this \yii\web\View
 * @var $model \app\modules\blog\models\Post
 */

$link = Url::toRoute(['/blog/post/view', 'slug' => $model->slug]);
$img = Html::img(
    Img::getUrl($model->img, false),
    ['alt' => Html::encode($model->title), 'style' => 'width: 100%']
);

?>
<div class="card">
    <?php if ($model->img !== null) : ?>
    <a href="<?= $link ?>" style="display: block">
        <div class="card__img" style="height: 200px; background-position: center center; background-size: cover; display: block; background-image: url(<?=Img::getUrl($model->img, false)?>)"></div>
    </a>
    <?php endif; ?>
    <div class="card__describe">
        <h3 class="media-heading"><a href="<?= $link ?>"><?= Html::encode($model->title) ?></a></h3>
        <?php if (!empty($model->short)) : ?>
            <div class="describe"><?= Html::encode($model->short) ?></div>
        <?php endif; ?>
        <div class="date"><?= Yii::$app->formatter->asDate($model->publish_at, 'long') ?></div>
        <?= PostMetaWidget::widget(['model' => $model]) ?>
    </div>
</div>