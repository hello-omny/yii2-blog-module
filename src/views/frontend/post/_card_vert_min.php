<?php

use yii\helpers\Url;
use yii\bootstrap\Html;
use app\modules\image\models\Img;

/**
 * @var $this \yii\web\View
 * @var $model \app\modules\blog\models\Post
 */

$link = Url::toRoute(['/blog/post/view', 'slug' => $model->slug]);
$img = Html::img(Img::getUrl($model->img, false), ['alt' => Html::encode($model->title), 'height' => '80']);
?>
<a href="<?=$link?>">
    <?=$img?>
    <div class="title"><?= Html::encode($model->title) ?></div>
</a>