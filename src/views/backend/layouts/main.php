<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use omny\yii2\blog\module\assets\BlogModuleBackendAsset;

/**
 * @var $this View
 * @var $content string
 */

BlogModuleBackendAsset::register($this);

?>
<?php $this->beginContent('@vendor/omny/yii2-blog-module/src/views/layouts/common.php') ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <ul class="list-inline text-center">
                <li><?= Html::a('Создать', ['default/create']) ?></li>
                <li><?= Html::a('Черновики', ['default/draft']) ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="page-title">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <h1><?= $this->title ?></h1>
    </div>

    <?= $content ?>
</div>
<?php $this->endContent() ?>
