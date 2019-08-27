<?php

use omny\yii2\blog\module\models\Category;
use omny\yii2\blog\module\models\Post;
use omny\yii2\blog\module\models\TagToPost;
use yii\db\Migration;

class m000000_000001_blog_category extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(
            Category::tableName(),
            [
                'id' => $this->bigPrimaryKey()->unsigned(),
                'title' => $this->string()->notNull(),
                'slug' => $this->string()->notNull()->unique(),

                'short' => $this->text(),
                'body' => $this->text()->notNull(),
                'status' => $this->smallInteger()->notNull()->defaultValue(Category::STATUS_HIDDEN),

                'img_id' => $this->bigInteger()->unsigned()->null()->defaultValue(null),
                'parent_id' => $this->bigInteger()->unsigned()->null()->defaultValue(null),

                'updated' => $this->timestamp(),
                'created' => $this->dateTime(),
            ],
            $tableOptions
        );

        $this->createIndex('idx__category__slug', Category::tableName(), 'slug');
        $this->createIndex('idx__category__img', Category::tableName(), 'img_id');
        $this->createIndex('idx__category__status', Category::tableName(), 'status');
    }

    public function down()
    {
        $this->dropTable(Category::tableName());
    }
}
