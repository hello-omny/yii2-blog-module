<?php

namespace omny\yii2\blog\module\controllers\backend;

use omny\yii2\blog\module\actions\DeletePostAction;
use omny\yii2\blog\module\actions\TagListAction;
use omny\yii2\blog\module\models\Img;
use omny\yii2\blog\module\models\Post;
use omny\yii2\blog\module\repository\PostRepository;
use omny\yii2\blog\module\search\backend\PostSearch;
use omny\yii2\blog\module\models\Category;
use vova07\imperavi\actions\GetImagesAction;
use vova07\imperavi\actions\UploadFileAction;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\di\NotInstantiableException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class DefaultController
 * @package omny\yii2\blog\module\controllers\backend
 */
class DefaultController extends AbstractBackendController
{
    /**
     * @return array
     */
    public function actions(): array
    {
        return [
            'image-get' => [
                'class' => GetImagesAction::class,
                'url' => Url::to('@web/img/blog', true), // Directory URL address, where files are stored.
                'path' => '@webroot/img/blog', // Or absolute path to directory where files are stored.
                //'type' => \vova07\imperavi\actions\GetAction::TYPE_IMAGES,
            ],
            'image-upload' => [
                'class' => UploadFileAction::class,
                'url' => Url::to('@web/img/blog', true), // Directory URL address, where files are stored.
                'path' => '@webroot/img/blog', // Or absolute path to directory where files are stored.
                'unique' => true,
            ],
            'delete' => [
                'class' => DeletePostAction::class,
            ],
            'tag-list' => [
                'class' => TagListAction::class,
            ]
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(\Yii::$app->getRequest()->queryParams);

        /** @var ActiveQuery $query */
        $query = $dataProvider->query;
        $query->addOrderBy(['created' => SORT_DESC]);
        $query->joinWith(['category' => function (ActiveQuery $query) {
            $query->select([
                Category::tableName() . '.title',
                Category::tableName() . '.id',
            ]);
        }]);
        $dataProvider->sort->attributes['category'] = [
            'asc' => [Category::tableName() . '.title' => SORT_ASC],
            'desc' => [Category::tableName() . '.title' => SORT_DESC],
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new Post([
            'user_id' => \Yii::$app->getUser()->getId(),
            'status' => Post::STATUS_HIDDEN,
        ]);
        $imgModel = new Img();
        $request = \Yii::$app->getRequest();

        if ($model->load($request->post()) && $imgModel->load($request->post())) {
            if (!$model->save()) {
                throw new Exception('Post not saved.' . print_r($model->errors, true));
            };

            $path = $imgModel->generatePath(\Yii::$app->getUser()->getId(), $model->id);
            if ($imgModel->uploadImage($path)) {
                $model->link('img', $imgModel);
            };

            return $this->redirect(['index']);
        }

        return $this->render('create', compact('model', 'imgModel'));
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws Exception
     * @throws NotFoundHttpException
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    public function actionUpdate(int $id)
    {
        /** @var PostRepository $postRepository */
        $postRepository = \Yii::$container->get(PostRepository::class);
        $model = $postRepository->findOneById($id);

        if ($model === null) {
            throw new NotFoundHttpException('Post not found.');
        }

        /** @var Img $imgModel */
        $imgModel = $model->img;

        if ($imgModel === null) {
            $imgModel = new Img();
        }

        $request = \Yii::$app->getRequest();
        if ($model->load($request->post())) {
            if (!$model->save()) {
                throw new Exception('Post not saved.' . print_r($model->errors, true));
            };

            if ($imgModel->load($request->post())) {
                $path = $imgModel->generatePath(\Yii::$app->getUser()->getId(), $model->id);
                if ($imgModel->uploadImage($path)) {
                    $model->link('img', $imgModel);
                };
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', compact('model', 'imgModel'));
    }

    public function actionDraft()
    {
        /** @var PostRepository $postRepository */
        $postRepository = \Yii::$container->get(PostRepository::class);
        $provider = new ActiveDataProvider([
            'query' => $postRepository->getDraftForUserQuery(\Yii::$app->getUser()->getId())
        ]);

        return $this->render('draft', compact('provider'));
    }

    /**
     * @param int $id
     * @return string
     * @throws InvalidConfigException
     * @throws NotFoundHttpException
     * @throws NotInstantiableException
     */
    public function actionView(int $id): string
    {
        /** @var PostRepository $postRepository */
        $postRepository = \Yii::$container->get(PostRepository::class);
        $model = $postRepository->getOneByIdQuery($id)
            ->byUser(\Yii::$app->getUser()->getId())
            ->one();

        if ($model === null) {
            throw new NotFoundHttpException('Post not found.');
        }

        return $this->render('view', compact('model'));
    }

}
