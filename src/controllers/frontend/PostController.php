<?php

namespace omny\yii2\blog\module\controllers\frontend;

use omny\yii2\blog\module\models\Post;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class PostController
 * @package omny\yii2\blog\module\controllers\frontend
 */
class PostController extends Controller
{
    /** @var string */
    public $layout = 'article';

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            Url::remember();
            return true;
        }
        return false;
    }

    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(string $slug)
    {
        $model = Post::find()
            ->active()
            ->andWhere([
                'slug' => $slug
            ])
            ->with(['category', 'img', 'tags'])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException("Материал не найден.");
        }

        $newPosts = Post::find()
            ->active()
            ->with(['img', 'category'])
            ->limit(7)
            ->all();

        $this->setupView($model);
        $this->setupMeta($model);

        return $this->render('view', [
            'model' => $model,
            'newPosts' => $newPosts,
            'h1Title' => Html::encode($model->title),
        ]);
    }

    /**
     * @param Post $model
     */
    private function setupView($model)
    {
        $title = Html::encode($model->title);
        $metaTitle = $model->getBehavior('MetaTag')->title;
        $this->view->title = empty($metaTitle) ? $title : $metaTitle;

        $this->view->params['category'] = $model->category;
        $this->view->params['breadcrumbs'][] = [
            'label' => "Темы",
            'url' => ['/blog/default/index']
        ];
        $crumbs = [];
        $crumbs[] = [
            'label' => $model->category->title,
            'url' => ['/blog/category/view', 'slug' => $model->category->slug]
        ];
        $parent = $model->category;
        while ($parent = $parent->parent) {
            $crumbs[] = [
                'label' => $parent->title,
                'url' => ['/blog/category/view', 'slug' => $parent->slug]];
            $this->view->params['category'] = $parent;
        }

        $this->view->params['breadcrumbs'] = array_merge(
            $this->view->params['breadcrumbs'],
            array_reverse($crumbs)
        );
    }

    /**
     * @param Post $model
     */
    private function setupMeta($model)
    {
        $title = $model->getBehavior('MetaTag')->title;
        if (empty($title)) {
            $title = $model->title;
        }

        // Keywords
        $keywords = $model->getBehavior('MetaTag')->keywords;

        if (empty($keywords)) {
            $tags = $model->tags;
            $keywords = [];
            foreach ($tags as $tag) {
                $keywords[] = $tag->title;
            }
            $keywords[] = $model->title;
            $keywords = implode(', ', $keywords);
        }

        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);

        // Description
        $description = $model->getBehavior('MetaTag')->description;
        if (empty($description)) {
            $description = StringHelper::truncateWords(strip_tags($model->body), 24, '');
            $description = str_replace(PHP_EOL, '', $description);
        }
        if (empty($description)) {
            $description = $title;
        }

        $this->view->registerMetaTag(['name' => 'description', 'content' => $description]);

        $img = null;
        if (!is_null($model->img)) {
            $img = Img::getUrl($model->img);
        }

        // Og scheme
        $this->view->registerMetaTag(['property' => 'og:type', 'content' => 'article'], 'og:type');
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => $title], 'og:title');
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => $description], 'og:description');
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => Url::to('', true)], 'og:url');
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => $img], 'og:image');
    }
}
