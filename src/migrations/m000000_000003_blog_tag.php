<?php

use omny\yii2\blog\module\models\Category;
use omny\yii2\blog\module\models\Post;
use omny\yii2\blog\module\models\Tag;
use omny\yii2\blog\module\models\TagToPost;
use yii\db\Migration;

class m000000_000003_blog_tag extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(
            Tag::tableName(),
            [
                'id' => $this->primaryKey(),
                'title' => $this->string()->notNull(),
                'slug' => $this->string()->notNull()->unique(),
                'frequency' => $this->integer()->defaultValue(1),

                'status' => $this->smallInteger()->notNull()->defaultValue(0),

                'updated_at' => $this->timestamp(),
                'created_at' => $this->timestamp(),
            ],
            $tableOptions
        );
        $this->createIndex('idx__tag__slug', Tag::tableName(), 'slug');

        $this->createTable(
            TagToPost::tableName(),
            [
                'id' => $this->primaryKey(),
                'tag_id' => $this->integer(),
                'post_id' => $this->integer(),
            ]
        );
        $this->createIndex('idx__tag_to_post__tag_id', TagToPost::tableName(), 'tag_id');
        $this->createIndex('idx__tag_to_post__post_id', TagToPost::tableName(), 'post_id');
    }

    public function down()
    {
        $this->dropTable(Tag::tableName());
        $this->dropTable(TagToPost::tableName());
    }
}
