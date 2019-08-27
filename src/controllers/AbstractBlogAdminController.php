<?php

namespace app\modules\blog\controllers;

use app\controllers\AbstractAdminController;
use app\modules\catalog\components\Finder;

/**
 * Class AbstractCatalogAdminController
 * @package app\modules\catalog\controllers
 */
abstract class AbstractBlogAdminController extends AbstractAdminController
{
    /** @var string */
    public $layout = 'main';

    /** @var Finder */
    protected $finder;

    public function init()
    {
        $this->finder = new Finder();
        parent::init();
    }
}
