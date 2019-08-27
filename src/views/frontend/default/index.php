<?php

use omny\yii2\blog\module\widgets\post\listViewMasonry\ListViewMasonryWidget;

/**
 * @var $this yii\web\View
 */
?>
<div class="block block-content" id="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <?php echo ListViewMasonryWidget::widget(); ?>
            </div>
            <div class="col-sm-3 col-sm-offset-1">
                <?php //echo NewPostsWidget::widget(['limit' => 3]); ?>
                <hr>
                <?php //echo PostWidget::widget(['type' => PostWidget::TYPE_VERTICAL]); ?>
            </div>
        </div>
    </div>
</div>