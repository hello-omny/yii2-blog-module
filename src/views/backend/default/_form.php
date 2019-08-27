<?php

use dosamigos\selectize\SelectizeTextInput;
use kartik\file\FileInput;
use omny\yii2\blog\module\models\Img;
use omny\yii2\blog\module\models\Post;
use omny\yii2\blog\module\repository\CategoryRepository;
use yii\helpers\Url;
use vova07\imperavi\Widget as Imperavi;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var Post $model app\modules\blog\models\Post
 * @var ActiveForm $form
 * @var Img $imgModel
 */

$form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data'
    ],
]);
?>
<div class="post-form">
    <div class="row">
        <div class="col-sm-8">
            <?php
            echo $form->field($model, 'title')
                ->textInput(['maxlength' => true]);

            echo $form->field($model, 'tagNames')
                ->widget(
                    SelectizeTextInput::class,
                    [
                        'loadUrl' => ['default/tag-list'],
                        'options' => ['class' => 'form-control'],
                        'clientOptions' => [
                            'delimiter' => ',',
                            'plugins' => ['remove_button'],
                            'valueField' => 'title',
                            'labelField' => 'title',
                            'searchField' => ['title'],
                            'create' => false,
                        ],
                    ])->hint('Разделитель — запятая.');

            echo $form->field($model, 'short')->textarea(['rows' => 3]);
            echo $form->field($model, 'body')->textarea(['rows' => 10])
                ->widget(Imperavi::class, [
                    'settings' => [
                        'lang' => 'ru',
                        'minHeight' => 600,
                        'imageManagerJson' => Url::to(['default/image-get']),
                        'imageUpload' => Url::to(['default/image-upload']),
                        'plugins' => [
                            'clips',
                            'video',
                            'fullscreen',
                            'imagemanager',
                            'codemirror',
                        ],
                    ]
                ]);
            ?>
        </div>
        <div class="col-sm-4">
            <?php
            echo $form->field($model, 'category_id')
                ->dropDownList(CategoryRepository::getMap());

            echo $form->field($imgModel, 'image')
                ->widget(
                    FileInput::class,
                    [
                        'options' => [
                            'accept' => 'img/*',
                            'class' => 'form-group form-group-sm'
                        ],
                        'pluginOptions' => [
                            'initialPreview' => [
                                $imgModel->isNewRecord ?
                                    '' :
                                    Html::img(
                                        $imgModel->getViewUrl(),
                                        ['class' => 'img-responsive file-preview-image']
                                    ),
                            ],
                            'allowedFileExtensions' => ['jpg', 'jpeg', 'gif', 'png'],
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-primary btn-sm',
                            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                            'browseLabel' => 'Select Photo'
                        ],
                    ]
                );
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
