<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\StringHelper;
use app\modules\image\models\Img;

/**
 * @var $this \yii\web\View;
 * @var $model \app\modules\blog\models\Post;
 */

echo $this->render('@app/modules/blog/views/frontend/post/_card_hor_big', ['model' => $model]);
