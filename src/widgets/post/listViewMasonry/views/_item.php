<?php

/**
 * @var View $this
 * @var int $element
 * @var Post $model
 * @var mixed $key
 * @var int $index
 * @var ListView $widget
 * @var array $layout
 * @var \yii\data\Pagination $pagination
 * @var \yii\data\ActiveDataProvider $provider
 */

use omny\yii2\blog\module\models\Img;
use omny\yii2\blog\module\models\Post;
use omny\yii2\blog\module\widgets\post\listViewMasonry\ListViewMasonryWidget;
use yii\bootstrap\Html;
use yii\web\View;
use yii\widgets\ListView;

$currentLayout = ListViewMasonryWidget::getLayout($index, $layout);
$elementHeight = $layout[$currentLayout['line']][$currentLayout['key']];
$elementClass = $elementHeight;

if ($currentLayout['line'] === 0 && $currentLayout['key'] === 0) {
    echo Html::beginTag('div', ['class' => 'row card-row']);
}
?>
    <div class="col-sm-<?= $elementClass ?>">
        <div class="card">
            <?php

            $content = Html::tag('div', '', [
                'class' => 'card__img img-rounded',
                'style' => "height: " . $elementHeight / 2 . "00px; background-image: url('" . Img::getUrl($model->img) . "')"
            ]);

            echo Html::a($content,
                ['/blog/post/view', 'category' => $model->category->slug, 'slug' => $model->slug]
            );

            echo Html::tag('div',
                Html::a(Html::encode($model->category->title), ['/blog/category/view', 'slug' => $model->category->slug]),
                ['class' => 'card__category']
            );

            echo Html::tag('h3',
                Html::a(Html::encode($model->title),
                    ['/blog/post/view', 'category' => $model->category->slug, 'slug' => $model->slug],
                    ['class' => 'card__post-link']
                ),
                ['class' => 'card__title']
            );
            ?>
        </div>
    </div>
<?php

if ($currentLayout['closeRow']) {
    echo Html::endTag('div');
    echo Html::beginTag('div', ['class' => 'row card-row']);
}
if ($index === $provider->getCount() - 1) {
    echo Html::endTag('div');
};
