<?php

use omny\yii2\blog\module\models\Category;
use omny\yii2\blog\module\models\Post;
use omny\yii2\blog\module\models\TagToPost;
use yii\db\Migration;

class m000000_000002_blog_post extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(
            Post::tableName(),
            [
                'id' => $this->bigPrimaryKey()->unsigned(),
                'title' => $this->string()->notNull(),
                'slug' => $this->string()->unique(),

                'short' => $this->text(),
                'body' => $this->text(),

                'img_id' => $this->bigInteger()->unsigned()->null()->defaultValue(null),
                'category_id' => $this->bigInteger()->unsigned()->null()->defaultValue(null),
                'user_id' => $this->bigInteger()->unsigned()->null()->defaultValue(null),

                'status' => $this->smallInteger()->unsigned()->defaultValue(Post::STATUS_HIDDEN),

                'updated' => $this->timestamp(),
                'created' => $this->dateTime(),
            ],
            $tableOptions
        );

        $this->createIndex('idx__item__slug', Post::tableName(), 'slug');
        $this->createIndex('idx__item__img', Post::tableName(), 'img_id');
        $this->createIndex('idx__item__category', Post::tableName(), 'category_id');
        $this->createIndex('idx__item__user', Post::tableName(), 'user_id');
    }

    public function down()
    {
        $this->dropTable(Post::tableName());
    }
}
