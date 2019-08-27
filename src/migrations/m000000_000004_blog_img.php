<?php

use omny\yii2\blog\module\models\Img;
use yii\db\Migration;

class m000000_000004_blog_img extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(
            Img::tableName(),
            [
                'id' => $this->bigPrimaryKey()->unsigned(),

                'filename' => $this->string()->notNull()->unique(),
                'alt' => $this->string(),
                'title' => $this->string(),

                'updated' => $this->timestamp(),
                'created' => $this->dateTime(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable(Img::tableName());
    }
}
