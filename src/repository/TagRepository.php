<?php

namespace omny\yii2\blog\module\repository;

use omny\yii2\blog\module\models\Tag;

/**
 * Class TagRepository
 * @package omny\yii2\blog\module\repository
 */
class TagRepository
{
    public function findAllByName($query)
    {
        return Tag::find()
            ->andOnCondition(['like', 'title', $query])
            ->all();
    }
}
