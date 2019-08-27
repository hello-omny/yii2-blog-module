<?php

namespace omny\yii2\blog\module\query;

use omny\yii2\blog\module\models\Tag;
use omny\yii2\blog\module\models\Post;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class PostQuery
 * @package omny\yii2\blog\module\query
 *
 * @see Post
 */
class PostQuery extends ActiveQuery
{
    /**
     * @return PostQuery
     */
    public function active()
    {
        $date = date('Y-m-d H:i:s', strtotime(' + 10 minutes'));
        return $this->alias('post')
            ->andWhere(['post.status' => Post::STATUS_ACTIVE])
            ->andWhere(['<=', 'post.created', $date]);
    }

    /**
     * @return PostQuery
     */
    public function hidden()
    {
        return $this->alias('post')
            ->andWhere(['post.status' => Post::STATUS_HIDDEN]);
    }

    /**
     * @param string $title
     * @return $this
     */
    public function byTitle(string $title)
    {
        $this->andWhere(['title' => $title]);
        return $this;
    }

    /**
     * @param int $id
     * @return PostQuery
     */
    public function byUser(int $id)
    {
        return $this->andWhere(['user_id' => $id]);
    }

    /**
     * @param $slug
     * @return $this
     */
    public function bySlug(string $slug)
    {
        $this->andWhere(['slug' => $slug]);
        return $this;
    }

    /**
     * @param string $tags
     * @return PostQuery
     */
    public function byTags(string $tags)
    {
        return $this->joinWith([
            'tags' => function (ActiveQuery $query) use ($tags) {
                $query->andWhere([Tag::tableName() . '.title' => $tags]);
            }
        ]);
    }

    /**
     * @param null $db
     * @return array|ActiveRecord[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param null $db
     * @return array|ActiveRecord|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
