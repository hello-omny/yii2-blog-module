<?php

namespace app\modules\blog\controllers\frontend;

use Yii;
use app\modules\blog\models\Tag;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Html;
use yii\web\Response;

class TagController extends \yii\web\Controller
{
    public $layout = 'category';

    public function actionIndex()
    {
        $tags = Tag::find()
            ->with(['post' => function ($query) {
                $query->active();
            },])
            ->all();

        $maxTag = $this->getTopTag($tags);

        return $this->render('index', ['tags' => $tags, 'maxTag' => $maxTag]);
    }

    public function actionView($slug)
    {
        $model = $this->findModel($slug);

        $items = $model->getPost()
            ->active();

        $items = new ActiveDataProvider([
            'query' => $items,
            'pagination' => [
                'pageSize' => 11,
            ],
        ]);

        $this->setupView($model);
        $this->setupMeta($model);

        return $this->render('view', [
            'model' => $model,
            'items' => $items
        ]);
    }

    protected function getTopTag($tags)
    {
        $max = 1;
        foreach ($tags as $tag)
            $max = count($tag->post) > $max ? count($tag->post) : $max;

        return $max;
    }

    protected function findModel($slug)
    {
        $model = Tag::find()
            ->bySlug($slug)
            ->one();

        return $model;
    }

    private function setupView(Tag $model)
    {
        $this->view->title = Html::encode("Статьи с меткой: «" . $model->title . "»");

        $this->view->params['breadcrumbs'][] = [
            'label' => "Темы",
            'url' => ['/blog/default/index']
        ];
        $this->view->params['breadcrumbs'][] = [
            'label' => "Тэги",
            'url' => ['/blog/tag/index']
        ];
    }

    private function setupMeta(Tag $model)
    {
        // register Meta
        $keywords = '';
        $description = '';

        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => $description]);
    }
}