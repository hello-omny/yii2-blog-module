<?php

use yii\bootstrap\Html;

/**
 * @var $this yii\web\View
 * @var $tags \app\modules\blog\models\Tag[]
 */

$this->title = 'Тэги';

$firstStyle = 'font-size: 16px';
$secondStyle = 'font-size: 26px';
$thirdStyle = 'font-size: 33px';
$fourthStyle = 'font-size: 41px';
?>
<div class="block">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <ul class="list-inline">
                    <?php
                    foreach ($tags as $tag) {
                        $countItems = count($tag->post);
                        $style = 'font-size: 14px';

                        if ($countItems >= $maxTag)
                            $style = $fourthStyle;
                        elseif ($countItems >= $maxTag / 2)
                            $style = $thirdStyle;
                        elseif ($countItems >= $maxTag / 3)
                            $style = $secondStyle;
                        elseif ($countItems >= $maxTag / 4)
                            $style = $firstStyle;


                        echo Html::tag('li', Html::a($tag->title, ['/blog/tag/view', 'slug' => $tag->slug]), ['style' => $style]);
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>