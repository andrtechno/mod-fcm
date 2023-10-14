<?php

namespace panix\mod\fcm\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;

class DefaultController extends AdminController
{


    /**
     * Display banner list.
     */
    public function actionIndex()
    {
        $this->pageName = Yii::t('chatgpt/default', 'MODULE_NAME');
        $this->view->params['breadcrumbs'] = [$this->pageName];
        $this->buttons = [
            [
                'icon' => 'export',
                'label' => Yii::t('fcn/default', 'Send test msg'),
                'url' => ['settings/send'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        /*$searchModel = new ChatGPTSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        if (Yii::$app->user->can("/{$this->module->id}/{$this->id}/*") || Yii::$app->user->can("/{$this->module->id}/{$this->id}/create")) {
            $this->buttons = [
                [
                    'label' => Yii::t('chatgpt/ChatGPT', 'CREATE_BANNER'),
                    'url' => ['create'],
                    'icon' => 'add',
                    'options' => ['class' => 'btn btn-success']
                ]
            ];
        }*/
        return $this->render('index', [
            //'dataProvider' => $dataProvider,
            //'searchModel' => $searchModel,
        ]);

    }


}
