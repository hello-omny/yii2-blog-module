<?php

use yii\widgets\ListView;

/**
 * @var $this yii\web\View;
 * @var $model app\modules\blog\models\Tag;
 * @var $items \yii\data\ActiveDataProvider;
 */

$this->title = $model->title;
?>
<div class="block">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <?php
                echo ListView::widget([
                    'dataProvider' => $items,
                    'itemView' => '_list_item',
                    'summary' => false,
                ]);
                ?>
            </div>
            <div class="col-sm-3 col-sm-offset-1">

            </div>
        </div>
    </div>
</div>
