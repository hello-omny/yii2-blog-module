<?php

namespace omny\yii2\blog\module\models;

use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use omny\yii2\blog\module\query\TagQuery;

/**
 * Class Tag
 * @package omny\yii2\blog\module\models
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $frequency
 * @property integer $status
 * @property string $updated_at
 * @property mixed $post
 * @property string $created_at
 */
class Tag extends ActiveRecord
{
    public $postCount;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'slug'], 'required'],
            [['status', 'frequency'], 'integer'],
            [['updated_at', 'created_at', 'frequency'], 'safe'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'frequency' => 'Frequency',
            'status' => 'Status',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
            ],
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // если вместо метки времени UNIX используется datetime:
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getPost()
    {
        return $this->hasMany(Post::class, ['id' => 'post_id'])
            ->viaTable(TagToPost::tableName(), ['tag_id' => 'id']);
    }

    /**
     * @return TagQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new TagQuery(get_called_class());
    }
}
