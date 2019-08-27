<?php

namespace omny\yii2\blog\module\models;

use Yii;
use omny\yii2\blog\module\query\PostQuery;
use dosamigos\taggable\Taggable;
use lan143\yii2_yandexturbo\YandexTurboBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Class Post
 * @package omny\yii2\blog\module\models
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $short
 * @property string $body
 * @property integer $img_id
 * @property integer $category_id
 * @property integer $user_id
 * @property integer $status
 * @property string $created
 * @property string $updated
 *
 * @property Category $category
 * @property mixed $tags
 * @property mixed $user
 * @property Img $img
 */
class Post extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_HIDDEN = 0;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'post';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['short', 'body'], 'string'],
            [['img_id', 'category_id', 'user_id', 'status'], 'integer'],
            [['updated', 'created'], 'safe'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['tagNames'], 'safe'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
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
            'img_id' => 'Img ID',
            'category_id' => 'Category ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'updated' => 'Updated',
            'created' => 'Created',
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'slug' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'immutable' => true,
                'ensureUnique' => true,
            ],
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'taggable' => [
                'class' => Taggable::class,
                'name' => 'title',
            ],
            /**
            'yandexTurbo' => [
                'class' => YandexTurboBehavior::class,
                'scope' => function (ActiveQuery $query) {
                    $query->active()
                        ->orderBy(['publish_at' => SORT_DESC]);
                },
                'dataClosure' => function (Post $model) {
                    return [
                        'title' => $model->title,
                        'link' => Url::to(['/blog/post/view', 'slug' => $model->slug], true),
                        'description' => $model->short,
                        'content' => $model->body,
                        'pubDate' => (new \DateTime($this->publish_at))->format(\DateTime::RFC822),
                    ];
                }
            ],
             */
        ];
    }

    /**
     * @inheritdoc
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImg()
    {
        return $this->hasOne(Img::class, ['id' => 'img_id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('{{%tag_to_post}}', ['post_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl($folder = false)
    {
        // return a default image placeholder if your source avatar is not found
        $filename = isset($this->img->filename) ? $this->img->filename : 'default.png';
        $full_path = $folder ? Yii::getAlias('@webroot') . '/' . $folder . '/' . $filename : Yii::getAlias('@webroot') . '/' . $filename;

        return $full_path;
    }
}
