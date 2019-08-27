<?php

namespace omny\yii2\blog\module\repository;

use omny\yii2\blog\module\models\Category;
use yii\helpers\ArrayHelper;

/**
 * Class CategoryRepository
 * @package omny\yii2\blog\module\repository
 */
class CategoryRepository
{
    /**
     * @return array
     */
    public static function getMap(): array
    {
        return ArrayHelper::map(Category::find()->all(), 'id', 'title');
    }
}
