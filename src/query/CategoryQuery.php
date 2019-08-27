<?php

namespace omny\yii2\blog\module\query;

use yii\db\ActiveQuery;
use omny\yii2\blog\module\models\Category;

/**
 * This is the ActiveQuery class for [[Category]].
 *
 * @see Category
 */
class CategoryQuery extends ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        $this->with(['posts' => function ($query) {
            $query->andWhere(['status' => 1])
                ->andWhere(['<=', 'publish_at', date('Y-m-d H:i:s + 5 second')]);
        }]);
        return $this;
    }

    public function bySlug($slug)
    {
        $this->andWhere(['slug' => $slug]);

        return $this;
    }

    public function byTitle($title)
    {
        $this->andWhere(['title' => $title]);

        return $this;
    }

    /**
     * @inheritdoc
     * @return Category[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    public function root()
    {
        return $this->andWhere(['parent_id' => null]);
    }

    /**
     * @inheritdoc
     * @return Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}