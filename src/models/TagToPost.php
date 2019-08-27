<?php

namespace omny\yii2\blog\module\models;

use yii\db\ActiveRecord;

/**
 * Class TagToPost
 * @package omny\yii2\blog\module\models
 *
 * @property integer $id
 * @property integer $tag_id
 * @property integer $post_id
 */
class TagToPost extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'tag_to_post';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['tag_id', 'post_id'], 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'tag_id' => 'Tag ID',
            'post_id' => 'Post ID',
        ];
    }
}
