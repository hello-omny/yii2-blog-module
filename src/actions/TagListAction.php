<?php

namespace omny\yii2\blog\module\actions;

use omny\yii2\blog\module\repository\TagRepository;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;
use yii\web\Response;

/**
 * Class TagListAction
 * @package omny\yii2\blog\module\actions
 */
class TagListAction extends Action
{
    /**
     * @param $query
     * @return array
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    public function run($query)
    {
        /** @var TagRepository $tagRepository */
        $tagRepository = \Yii::$container->get(TagRepository::class);

        $models = $tagRepository->findAllByName($query);
        $items = [];

        foreach ($models as $model) {
            $items[] = ['title' => $model->title];
        }
        \Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        return $items;
    }
}
