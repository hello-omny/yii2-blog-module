<?php

/**
 * @var $this \yii\web\View;
 * @var $model \app\modules\blog\models\Post;
 * @var $category \app\modules\blog\models\Category;
 * @var int $index
 */

use app\widgets\ads\InListWidget;

?>
    <div class="list-post-margin">
        <?php echo $this->render('@app/modules/blog/views/frontend/post/_card_hor_big', ['model' => $model]); ?>
    </div>
<?php if (($index + 1) % 3 == 0) : ?>
    <div class="list-post-margin">
        <?php echo InListWidget::widget() ?>
    </div>
<?php endif; ?>