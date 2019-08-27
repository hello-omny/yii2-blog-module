<?php

namespace omny\yii2\blog\module\controllers\frontend;


use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\web\NotFoundHttpException;

/**
 * Class CategoryController
 * @package omny\yii2\blog\module\controllers\frontend
 */
class CategoryController extends AbstractFrontendController
{
    public function actionView($slug)
    {
        $category = Category::find()
            ->with('parent')
            ->active()
            ->bySlug($slug)
            ->one();

        if ($category === null) {
            throw new NotFoundHttpException('Категория не найдена!');
        }

        // ToDo: перенести в модель
        if ($category->parent === null) { // root category
            $subCategories = Category::getActiveSubCategories($category->categories);
            $subCategoriesIds = ArrayHelper::getColumn($subCategories, 'id');
            array_push($subCategoriesIds, $category->id);

            $models = Post::find()
                ->with(['user' => function ($query) {
                    $query->with('profile');
                }, 'category', 'tags', 'img'])
                ->andWhere(['in', 'category_id', $subCategoriesIds])
                ->active()
                ->orderBy('created_at DESC');
        } else {
            $models = $category
                ->getItems()
                ->with(['user' => function ($query) {
                    $query->with('profile');
                }, 'category', 'tags', 'img'])
                ->active()
                ->orderBy('created_at DESC');
        }

        $this->setupMeta($category);
        $this->setupView($category);

        $models = new ActiveDataProvider([
            'query' => $models,
            'pagination' => [
                'defaultPageSize' => 11,
            ],
        ]);

        return $this->render('view', [
            'category' => $category,
            'models' => $models
        ]);
    }

    private function setupView($model)
    {
        $this->view->title = Html::encode($model->title);
        $this->view->params['breadcrumbs'][] = [
            'label' => "Темы",
            'url' => ['/blog/default/index']
        ];

        $crumbs = [];
        $parent = $model;
        $this->view->params['category'] = $parent;
        while ($parent = $parent->parent) {
            $crumbs[] = [
                'label' => $parent->title,
                'url' => ['/blog/category/view', 'category' => $parent->slug]];
            $this->view->params['category'] = $parent;
        }

        $this->view->params['breadcrumbs'] = array_merge($this->view->params['breadcrumbs'], array_reverse($crumbs));
    }

    private function setupMeta(Category $articleCategory)
    {
        $keywords = $articleCategory->title;
        $description = StringHelper::truncateWords(strip_tags($articleCategory->body), 24, '');
        $description = str_replace(PHP_EOL, '', $description);

        $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $keywords
        ]);
        if (strlen($description) > 1)
            $this->view->registerMetaTag([
                'name' => 'description',
                'content' => $description
            ]);
    }
}
