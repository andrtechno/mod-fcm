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
        $this->view->params['breadcrumbs'] = [
            $this->pageName
        ];

        $this->buttons = [
            [
                'icon' => 'export',
                'label' => Yii::t('fcn/default', 'Send test msg'),
                'url' => ['/admin/fcm/settings/send'],
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


    /**
     * Экспорт всех поставщиков их контактов
     * @param string $delimiter default ";"
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function actionSend()
    {
        $deviceId = 'ccDr-wRIT-Cn-eCboSww4P:APA91bE6MildSU3fmFP9s7iJj8CeiI_YA7bMHitd0IxiSqxwxuxELkiTB2KRu8D4PZCP7f-HjoCDOW_ZakiRp35yc1mhfJ23LF0s5l75MWS_Yx_WPzCrC-UHJ8dcDhhcsAHYS7J4iB_z';
        $client = new \Fcm\FcmClient(Yii::$app->settings->get('fcm', 'server_key'), '');

        return $this->render('send', [
            'client' => $client,
            'deviceId' => $deviceId
        ]);

    }

}
