<?php

use yii\helpers\Url;
use yii\bootstrap\Html;
use app\modules\image\models\Img;

/**
 * @var $this \yii\web\View
 * @var $model \app\modules\blog\models\Post
 */

$link = Url::toRoute(['/blog/post/view', 'slug' => $model->slug]);
$img = Html::img(Img::getUrl($model->img, false), ['alt' => Html::encode($model->title), 'height' => '80', 'width' => '80']);
?>
<div class="media">
    <?php if (!empty($model->img)) :?>
    <div class="media-left">
        <a href="<?= $link ?>"><?=$img?></a>
    </div>
    <?php endif; ?>
    <div class="media-body">
        <div class="media-heading"><a href="<?= $link ?>"><?= Html::encode($model->title) ?></a></div>
        <div class="date"><?= Yii::$app->formatter->asDate($model->publish_at, 'medium') ?></div>
    </div>
</div>