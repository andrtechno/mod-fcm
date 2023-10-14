<?php

namespace panix\mod\fcm\controllers\admin;


use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\fcm\models\UsersFcmSearch;

class DefaultController extends AdminController
{

    public function actionIndex()
    {
        $this->pageName = Yii::t('fcm/default', 'MODULE_NAME');
        $this->view->params['breadcrumbs'] = [$this->pageName];
        $this->buttons = [
            [
                'icon' => 'export',
                'label' => Yii::t('fcm/default', 'Send test msg'),
                'url' => ['settings/send'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $searchModel = new UsersFcmSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);

    }


}
