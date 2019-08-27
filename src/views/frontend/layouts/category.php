<?php

use yii\bootstrap\Html;
use yii\widgets\Breadcrumbs;

/**
 * @var $this \yii\web\View;
 */
?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<?php if (!empty($this->params['breadcrumbs'])) : ?>
    <div class="block block__breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="block block-page-title">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-header"><?= Html::encode($this->title); ?></h1>
            </div>
        </div>
    </div>
</div>
<hr>
<?= $content; ?>
<?php $this->endContent() ?>
