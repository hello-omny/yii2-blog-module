<?php

namespace omny\yii2\blog\module\repository;

use omny\yii2\blog\module\models\Post;
use omny\yii2\blog\module\query\PostQuery;

/**
 * Class PostRepository
 * @package omny\yii2\blog\module\repository
 */
class PostRepository
{
    /**
     * @param int $id
     * @return Post|null
     */
    public function findOneById(int $id): ?Post
    {
        return static::getOneByIdQuery($id)
            ->one();
    }

    /**
     * @param int $id
     * @return PostQuery
     */
    public function getOneByIdQuery(int $id)
    {
        return Post::find()
            ->andWhere(['id' => $id])
            ->with(['category', 'img', 'tags']);
    }

    /**
     * @param string $slug
     * @return Post|null
     */
    public function findOneBySlug(string $slug): ?Post
    {
        return Post::find()
            ->active()
            ->andWhere(['slug' => $slug])
            ->with(['category', 'img', 'tags'])
            ->one();
    }

    /**
     * @param int $userId
     * @return array
     */
    public function findDraftForUser(int $userId): array
    {
        return static::getDraftForUserQuery($userId)
            ->all();
    }

    /**
     * @param int $userId
     * @return PostQuery
     */
    public function getDraftForUserQuery(int $userId)
    {
        return Post::find()
            ->hidden()
            ->byUser($userId)
            ->with(['category', 'img', 'tags']);
    }

    /**
     * @param int|null $limit
     * @return PostQuery
     */
    public function getActiveQuery(int $limit = null)
    {
        $query = Post::find()
            ->active()
            ->with('category', 'img', 'tags')
            ->orderBy(['created' => SORT_DESC]);

        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query;
    }
}
