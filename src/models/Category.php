<?php

namespace omny\yii2\blog\module\models;

use omny\yii2\blog\module\query\CategoryQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Category
 * @package omny\yii2\blog\module\models
 *
 * @property ßActiveQuery $posts
 */
class Category extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_HIDDEN = 0;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'category';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title', 'slug', 'body'], 'required'],
            [['short', 'body'], 'string'],
            [['status', 'img_id', 'parent_id'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'short' => 'Short',
            'body' => 'Body',
            'status' => 'Status',
            'img_id' => 'Img ID',
            'parent_id' => 'Parent ID',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return CategoryQuery|ActiveQuery
     */
    public static function find(): ActiveQuery
    {
        return new CategoryQuery(get_called_class());
    }

    /**
     * @return ActiveQuery
     */
    public function getPosts(): ActiveQuery
    {
        return $this->hasMany(Post::class, ['category_id' => 'id']);
    }
}
