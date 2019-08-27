<?php

namespace omny\yii2\blog\module\query;

use omny\yii2\blog\module\models\Tag;
use yii\db\ActiveQuery;

/**
 * Class TagQuery
 * @package omny\yii2\blog\module\query
 * @see Tag
 */
class TagQuery extends ActiveQuery
{
    /**
     * @return TagQuery|ActiveQuery
     */
    public function active(): ActiveQuery
    {
        return $this->andWhere(['status' => 1]);
    }

    /**
     * @param $slug
     * @return TagQuery|ActiveQuery
     */
    public function bySlug(string $slug): ActiveQuery
    {
        return $this->andWhere(['slug' => $slug]);
    }

    /**
     * @param $title
     * @return TagQuery|ActiveQuery
     */
    public function byTitle(string $title): ActiveQuery
    {
        return $this->andWhere(['title' => $title]);
    }
}
