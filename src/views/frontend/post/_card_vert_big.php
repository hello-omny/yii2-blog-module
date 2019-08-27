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
$img = Html::img(Img::getUrl($model->img, false), ['alt' => Html::encode($model->title), 'class' => 'img-responsive']);

?>
<div class="media">
    <div class="media-body">
        <a href="<?= $link ?>">
            <?php if ($img) {
                echo $img;
            }; ?>
            <h3 class="title"><?= Html::encode($model->title) ?></h3>
        </a>
        <?php if (!empty($model->short)) : ?>
            <div class="describe"><?= Html::encode($model->short) ?></div>
        <?php endif; ?>
        <?= PostMetaWidget::widget(['model' => $model]) ?>
    </div>
</div>