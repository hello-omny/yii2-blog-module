<?php
    /**
     * Created by PhpStorm.
     * User: ruslanzh
     * Date: 07/09/15
     * Time: 22:47
     *
     *
     * @var $model app\modules\article\models\Article;
     *
     */

    use yii\helpers\Html;
    use yii\helpers\HtmlPurifier;
    use yii\helpers\StringHelper;

    $viewCount = $model->statistic;

?>
<div class="media">
    <?php if ( $model->img ): ?>
        <div class="media-left">
            <?php //echo Html::a( Html::img( $model->getImageUrl( '' ), [ 'width' => 150 ] ), [ '/article/item/view', 'category' => $model->category->slug, 'slug' => $model->slug ] ); ?>
        </div>
    <?php endif; ?>
    <div class="media-body">
        <!--div class="small"><?php echo Html::a( $model->category->title, [ '/article/category/view', 'slug' => $model->category->slug ] ) ?></div-->
        <h4 class="media-heading"><?= Html::a( HtmlPurifier::process( $model->title ), [ '/article/item/view', 'category' => $model->category->slug, 'slug' => $model->slug ] ); ?></h4>
        <ul class="list-inline small">
            <li><?= Yii::$app->formatter->asDate( $model->publish_at, 'medium' ); ?></li>
            <li>Автор: <?= Html::a( $model->user->username, [ '/user/view/index', 'username' => $model->user->username ] ) ?></li>
            <?php /*foreach ( $model->tags as $tag ) : ?>
                <?php echo Html::tag( 'li',
                    Html::a( $tag->title, [
                        '/article/tag/view',
                        'slug' => $tag->slug
                    ] ) ); ?>
            <?php endforeach; */?>
            <li><span class="glyphicon glyphicon-eye-open"></span> <?= isset( $viewCount ) ? $viewCount->count : 0 ?></li>
        </ul>
        <!--p><?= StringHelper::truncateWords( HtmlPurifier::process( $model->body ), 15, '...' ) ?></p-->
        <!--p><?= Html::a( 'Читать полностью', [ '/article/item/view', 'category' => $model->category->slug, 'slug' => $model->slug ] ) ?></p-->
    </div>

</div>