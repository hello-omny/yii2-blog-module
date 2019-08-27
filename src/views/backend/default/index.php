<?php

use omny\yii2\blog\module\repository\CategoryRepository;
use omny\yii2\blog\module\search\backend\PostSearch;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $searchModel PostSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="block">
    <div class="row">
        <div class="col-sm-12">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-9">
            <div class="post-index">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        'id',
                        [
                            'attribute' => 'title',
                            'content' => function ($model) {
                                return Html::a($model->title, ['post/update', 'id' => $model->id]);
                            }
                        ],
                        [
                            'attribute' => 'category',
                            'label' => 'Категория',
                            'value' => 'category.title',
                            'filter' => Html::activeDropDownList(
                                $searchModel,
                                'categoryId',
                                CategoryRepository::getMap(),
                                ['class' => 'form-control', 'prompt' => 'Выберите...']
                            )
                        ],
                        'created',
                        'updated',

                        [
                            'class' => ActionColumn::class,
                            'template' => '{update}'
                        ],
                    ],
                ]); ?>
            </div>
        </div>
        <div class="col-sm-3">
            <p><?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?></p>
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>
</div>