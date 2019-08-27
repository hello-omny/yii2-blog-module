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
?>
<!--
<div class="media card-article">
    <?php if ($model->img): ?>
        <div class="media-left">
            <?php
            $_img = Img::getUrl($model->img, false);
            $imgTag = Html::tag(
                'div',
                '',
                [
                    'class' => 'background-img-responsive',
                    'style' => 'background-image: url(' . $_img . '); width: 300px; height: 250px'
                ]
            );
            echo Html::a(
                $imgTag,
                ['/article/item/view', 'category' => $model->category->slug, 'slug' => $model->slug]
            );
            ?>
        </div>
    <?php endif; ?>
    <div class="media-body">
        <h3 class="media-heading card-title">
            <?= Html::a(HtmlPurifier::process($model->title), ['/article/item/view', 'category' => $model->category->slug, 'slug' => $model->slug]); ?>
        </h3>
        <div class="card-content">

        </div>

        <div class="article-describe">
            <?= StringHelper::truncateWords(HtmlPurifier::process($model->body), 25, '...') ?>
        </div>

        <ul class="card-meta list-inline small">
            <li><?= Yii::$app->formatter->asDate($model->publish_at, 'full'); ?></li>
            <li><?= Yii::t('app', 'Author') ?>:
                <?php
                $userTitle = $model->user->profile->name ? $model->user->profile->name : $model->user->username;
                echo Html::a($userTitle, ['/user/view/index', 'username' => $model->user->username]);
                ?></li>
            <li>
                <ul class="list-inline">
                    <li><?= Yii::t('app', 'Tags') ?>:</li>
                    <?php
                    foreach ($model->tags as $tag) {
                        echo Html::tag('li',
                            Html::a($tag->title, [
                                '/article/tag/view',
                                'slug' => $tag->slug
                            ]));
                    }
                    ?>
                </ul>
            </li>
        </ul>

        <p><?= Html::a(
                Yii::t('app', 'Read more'),
                ['/article/item/view', 'category' => $model->category->slug, 'slug' => $model->slug],
                ['class' => 'btn btn-default']
            ) ?>
        </p>
    </div>

</div>
-->