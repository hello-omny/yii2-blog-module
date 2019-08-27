<?php


namespace omny\yii2\blog\module\actions;


use omny\yii2\blog\module\repository\PostRepository;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\db\StaleObjectException;
use yii\di\NotInstantiableException;
use yii\web\NotFoundHttpException;

/**
 * Class DeletePostAction
 * @package omny\yii2\blog\module\actions
 */
class DeletePostAction extends Action
{
    /** @var string */
    public $redirectAfter = 'index';

    /**
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws InvalidConfigException
     * @throws StaleObjectException
     * @throws NotInstantiableException
     */
    public function run(int $id)
    {
        /** @var PostRepository $postRepository */
        $postRepository = \Yii::$container->get(PostRepository::class);
        $model = $postRepository->getOneByIdQuery($id)
            ->byUser(\Yii::$app->getUser()->getId())
            ->one();

        if ($model === null) {
            throw new NotFoundHttpException('Post not found.');
        }

        $model->delete();

        return $this->controller->redirect([$this->redirectAfter]);
    }
}
