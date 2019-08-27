<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/**
 * @var $this \yii\web\View
 * @var $content string
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
<?= $content; ?>
<?php $this->endContent() ?>