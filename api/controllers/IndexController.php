<?php

namespace panix\mod\fcm\api\controllers;

use panix\engine\api\ApiActiveController;
use panix\engine\api\Serializer;
use panix\engine\api\ApiHelpers;
use panix\engine\CMS;
use panix\engine\controllers\WebController;
use panix\engine\data\ActiveDataProvider;
use panix\mod\discounts\models\Discount;
use panix\mod\fcm\models\UsersFcm;
use panix\mod\pages\models\Pages;
use panix\mod\shop\components\Filter;
use panix\mod\shop\components\FilterV2;
use panix\mod\shop\models\ProductCategoryRef;
use Yii;
use yii\helpers\Url;
use yii\web\Response;
use panix\mod\shop\components\FilterController;
use panix\mod\shop\models\Product;
use panix\mod\shop\models\Category;

/**
 * Class IndexController
 *
 * @property \panix\engine\data\ActiveDataProvider $provider
 *
 * @package panix\mod\fcm\controllers
 */
class IndexController extends ApiActiveController
{
    public $modelClass = 'panix\mod\fcm\api\models\Category';
    public $serializer = [
        'class' => Serializer::class,
    ];
    public $provider;

    public function beforeAction($action)
    {
        if (Yii::$app->request->headers->has('filter-ajax')) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [];
    }

    public function actionAddDevice()
    {
        $post = Yii::$app->request->post();

        $model = UsersFcm::findOne(['token' => $post['token']]);
        if (!$model) {
            $model = new UsersFcm;
        }
        $response['success'] = false;

        $post['UsersFcm'] = $post;
        $isNew = $model->isNewRecord;
        if ($model->load($post)) {
            if ($model->validate()) {
                if ($isNew) {
                    $model->created_at = time();
                    $model->save(false);
                }

                $response['success'] = true;
            }else{
                $response['errors']=$model->getErrors();
            }
        }

        return $this->asJson($response);
    }


}
