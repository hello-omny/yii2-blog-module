<?php

use app\modules\blog\widgets\CategoryTree\CategoriesTreeWidget;
use yii\widgets\ListView;
use app\modules\blog\widgets\Tags\TagsFromCategory;

/**
 * @var $this yii\web\View
 * @var $category app\modules\blog\models\Category
 * @var $models array of app\modules\blog\models\Article
 */
?>
<div class="block block-content" id="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <?= ListView::widget([
                    'dataProvider' => $models,
                    'viewParams' => ['category' => $category],
                    'summary' => false,
                    'itemView' => function ($model, $key, $index, $widget) {
                        return $this->render('_list_item', [
                            'model' => $model,
                            'key' => $key,
                            'index' => $index,
                            'widget' => $widget,
                        ]);
                    },
                ]);
                ?>
            </div>
            <div class="col-sm-3 col-sm-offset-1">
                <div class="sidebar">
                    <?php //echo CategoriesTreeWidget::widget( [ 'category' => $category ] ) ?>
                    <?php echo TagsFromCategory::widget([
                        'title' => 'Популярные темы: ',
                        'category' => $category->id
                    ])?>
                </div>
            </div>
        </div>
    </div>
</div>
