<?php

namespace omny\yii2\blog\module\controllers\frontend;

/**
 * Class DefaultController
 * @package omny\yii2\blog\module\controllers\frontend
 */
class DefaultController extends AbstractFrontendController
{
    public function actionIndex()
    {
        $this->setupView();
        $this->setupMeta();

        return $this->render('index');
    }

    private function setupView()
    {
        $this->view->title = "Темы";
        $this->view->params[ 'breadcrumbs' ][] = $this->view->title;
    }

    private function setupMeta()
    {
        $keywords = '';
        $description = '';

        $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $keywords
        ]);
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => $description
        ]);
    }
}
