<?php

namespace omny\yii2\blog\module\query;

use omny\yii2\blog\module\models\Img;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class ImgQuery
 * @package omny\yii2\blog\module\query
 * @see Img
 */
class ImgQuery extends ActiveQuery
{
    /**
     * @return ImgQuery|ActiveQuery
     */
    public function active(): ActiveQuery
    {
        return $this->andWhere(['status' => 1]);
    }

    /**
     * @param $filename
     * @return ImgQuery|ActiveQuery
     */
    public function byFileName($filename): ActiveQuery
    {
        return $this->andWhere(['filename' => $filename]);
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
