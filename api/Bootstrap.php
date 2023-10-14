<?php

namespace panix\mod\fcm\api;

use panix\engine\CMS;
use Yii;
use yii\base\BootstrapInterface;
use yii\rest\UrlRule;
use panix\mod\shop\models\Category;

/**
 * Class Module
 * @package panix\mod\fcm\api
 */
class Bootstrap implements BootstrapInterface
{

    public function bootstrap($app)
    {
        $rules[] = [
            'class' => UrlRule::class,
            'controller' => 'fcm/product',
            'pluralize' => false,
            'extraPatterns' => [
                'GET /' => 'index',
                'GET,HEAD <id>' => 'view',
            ],
            'tokens' => ['{id}' => '<id:\\w+>']
        ];
        $rules22[] = [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'fcm/filter',
            'pluralize' => false,
            'extraPatterns' => [
                'GET,POST /' => 'index',
                'GET,HEAD show' => 'show',
            ],
        ];

        $rules[] = [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'fcm/index',
            'pluralize' => false,
            'extraPatterns' => [
                'GET categories' => 'categories',
                'POST add-device' => 'add-device',
                'GET,POST nav' => 'test-nav',
                'GET search' => 'search',
                // 'GET,HEAD show' => 'show',
            ],
            'tokens' => ['{id}' => '<id:\\w+>']
        ];
        // CMS::dump($rules);die;
        //$rules['shop/search'] = 'shop/default/search';
        //$rules['catalog2/filter-categories'] = 'shop/catalog/filter-categories';



        $app->urlManager->addRules(
            $rules,
            false
        );
    }


}
