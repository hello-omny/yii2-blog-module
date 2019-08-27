<?php

use app\modules\blog\widgets\PostMeta\PostMetaWidget;
use app\modules\blog\widgets\PostsVertical\PostsVerticalWidget;
use app\modules\blog\widgets\SimilarArticles\SimilarItemsWidget;
use app\modules\blog\widgets\Tags\TagsForModelWidget;
use app\modules\image\models\Img;
use app\widgets\likely\LikelyWidget;
use yii\helpers\HtmlPurifier;
use app\widgets\ads\ArticleInnerWidget;
use yii\helpers\Html;
use app\modules\user\models\User;

/**
 * @var $this yii\web\View
 * @var string $h1Title
 * @var $model app\modules\blog\models\Post
 * @var $category app\modules\blog\models\Category
 */

$appUser = \Yii::$app->getUser();
$isAppUserAdmin = $appUser->can(User::ROLE_ADMIN);
?>
<div class="block block__page-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-header">
                    <?= Html::encode($h1Title); ?>
                </h1>
            </div>
        </div>
    </div>
</div>
<hr>
<?php if ($isAppUserAdmin): ?>
    <div class="block block-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">

                    <?= Html::a(
                        'edit',
                        ['/manage/article/default/update/', 'id' => $model->id],
                        ['class' => 'btn btn-default btn-sm']
                    ) ?>
                    <?= Html::a(
                        'delete',
                        ['/manage/article/default/delete/', 'id' => $model->id],
                        ['class' => 'btn btn-danger btn-sm']
                    ) ?>
                </div>
            </div>
        </div>
    </div>
    <hr>
<?php endif; ?>
<div class="block block-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <?= PostMetaWidget::widget(['model' => $model]) ?>
                <?php if (!is_null($model->img)): ?>
                    <div class="article-img"
                         style="height: 300px; background-image: url('<?= Img::getUrl($model->img, false) ?>'); background-repeat: no-repeat; background-size: cover; background-position: center"></div>
                <?php endif; ?> <br>
                <div>
                    <?= \app\widgets\ads\ArticleHeaderAdsWidget::widget(); ?>
                </div>

                <div class="row">
                    <div class="col-sm-7 col-sm-offset-1">
                        <div class="article-short">
                            <?php
                            if (!empty($model->short))
                                echo HtmlPurifier::process($model->short);
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <?= TagsForModelWidget::widget(['models' => $model->tags]) ?>
                    </div>
                </div>
                <br><br>
                <?php //echo ArticleInnerWidget::widget() ?>
                <div class="article-content">
                    <?php if ($model->category->slug == 'video') : ?>
                        <?= $model->body; ?>
                    <?php else : ?>
                        <?= HtmlPurifier::process($model->body); ?>
                    <?php endif; ?>
                </div>
                <?php //echo UserCardWidget::widget(['user' => $model->user]); ?>
            </div>
            <div class="col-sm-4">
                <?= PostsVerticalWidget::widget([
                    'models' => $newPosts,
                    'template' => '_card_hor_min',
                ]) ?>
                <div>
                    <?= \app\widgets\ads\SidebarAdsWidget::widget() ?>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="block">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div>
                    <?= \app\widgets\ads\ArticleHeaderAdsWidget::widget(); ?>
                </div>

                <hr>
                <div class="article-like-btn">
                    <?= LikelyWidget::widget([
                        'socials' => [
                            'facebook',
                            'vkontakte',
                            'odnoklassniki',
                        ],
                        'dataTitle' => $this->title,
                    ]); ?>
                </div>
                <hr>

                <?= \app\widgets\teasers\DefaultTeaserListWidget::widget() ?>
                <br>
                <?php
                echo SimilarItemsWidget::widget([
                    'item' => $model,
                    'tags' => $model->tags,
                ]);

                //                echo \yii2mod\comments\widgets\Comment::widget([
                //                    'model' => $model,
                //                ]);

                //                echo CommentsWidget::widget([
                //                    'canComment' => false,
                //                    'type' => 'item',
                //                    'nodeId' => $model->id,
                //                ]);
                ?>
            </div>
        </div>
    </div>
</div>