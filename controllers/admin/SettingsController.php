<?php

namespace panix\mod\fcm\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\fcm\models\SettingsForm;

class SettingsController extends AdminController
{

    public $icon = 'settings';

    public function actionIndex()
    {
        $this->pageName = Yii::t('app/default', 'SETTINGS');
        $this->view->params['breadcrumbs'][] = [
            'url' => ['/admin/fcm/default/index'],
            'label' => Yii::t('fcm/default', 'MODULE_NAME')
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;

        $this->buttons = [
            [
                'icon' => 'export',
                'label' => Yii::t('fcn/default', 'Send push'),
                'url' => ['/admin/fcm/default/send'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];

        $model = new SettingsForm();
        if ($model->load(Yii::$app->request->post())) {
            //print_r(Yii::$app->request->post());die;
            if ($model->validate()) {
                $model->save();
                Yii::$app->session->setFlash("success", Yii::t('app/default', 'SUCCESS_UPDATE'));
            } else {
                foreach ($model->getErrors() as $error) {
                    Yii::$app->session->setFlash("error", $error);
                }
            }
            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $model
        ]);
    }



}
