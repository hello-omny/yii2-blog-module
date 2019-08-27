<?php

use omny\yii2\blog\module\repository\CategoryRepository;
use omny\yii2\blog\module\search\backend\PostSearch;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model PostSearch
 * @var $form yii\widgets\ActiveForm
 */
?>
<div class="post-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]);

    echo $form->field($model, 'title');
    echo $form->field($model, 'categoryId')->dropDownList(CategoryRepository::getMap());
    ?>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
