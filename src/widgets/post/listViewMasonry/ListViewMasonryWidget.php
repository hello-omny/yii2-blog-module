<?php

namespace omny\yii2\blog\module\widgets\post\listViewMasonry;

use omny\yii2\blog\module\repository\PostRepository;
use yii\base\InvalidConfigException;
use yii\bootstrap\Widget;
use yii\data\ActiveDataProvider;
use yii\di\NotInstantiableException;

/**
 * Class ListViewMasonryWidget
 * @package omny\yii2\blog\module\widgets\post\listViewMasonry
 */
class ListViewMasonryWidget extends Widget
{
    /** @var int */
    public $limit = 13;
    /** @var array */
    public $layout = [
        [6, 4, 2],
        [4, 2, 4, 2],
        [2, 6, 4],
        [4, 6, 2]
    ];

    /**
     * @return string
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    public function run(): string
    {
        parent::run();

        /** @var PostRepository $postRepository */
        $postRepository = \Yii::$container->get(PostRepository::class);

        $provider = new ActiveDataProvider([
            'query' => $postRepository->getActiveQuery(),
            'pagination' => [
                'pageSize'=> 5
            ]
        ]);

        return $this->render('index', [
            'provider' => $provider,
            'limit' => $this->limit,
            'layout' => $this->layout,
        ]);
    }

    /**
     * @param int $index
     * @param array $layout
     * @return array
     */
    public static function getLayout(int $index, array $layout): array
    {
        $elementsCount = 0;
        $key = 0;
        $line = 0;

        foreach ($layout as $line => $row) {
            $rowElementsCount = count($row);

            if ($index < $elementsCount + $rowElementsCount) {
                $key = $index - $elementsCount;
                break;
            }
            $elementsCount += $rowElementsCount;
        }
        $lastElement = count($layout[$line]) === $key + 1;

        return [
            'line' => $line,
            'key' => $key,
            'closeRow' => count($layout[$line]) === $key + 1,
            'end' => $elementsCount === $index,
        ];
    }

    /**
     * @param array $layout
     * @return array
     */
    public static function getLayoutCounts(array $layout): array
    {
        $result = [];
        foreach ($layout as $row) {
            $result[] = count($row);
        }
        return $result;
    }
}
