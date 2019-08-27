<?php

namespace omny\yii2\blog\module\search\backend;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use omny\yii2\blog\module\models\Post;

/**
 * Class PostSearch
 * @package omny\yii2\blog\module\search\backend
 */
class PostSearch extends Model
{
    /** @var integer */
    public $id;
    /** @var integer */
    public $categoryId;
    /** @var string */
    public $title;

    /**
     * @return array
     */
    public function rules():array
    {
        return [
            [['id', 'categoryId'], 'integer'],
            [['title'], 'safe'],
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            Post::tableName().'.id' => $this->id,
            Post::tableName().'.category_id' => $this->categoryId,
        ]);

        $query->andFilterWhere(['like', Post::tableName().'.title', $this->title]);

        return $dataProvider;
    }
}
