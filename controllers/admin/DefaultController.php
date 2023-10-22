<?php

namespace panix\mod\fcm\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\fcm\models\UsersFcmSearch;
use panix\engine\Html;
use panix\mod\fcm\models\NotificationForm;

class DefaultController extends AdminController
{

    public function actionIndex()
    {
        $this->pageName = Yii::t('fcm/default', 'MODULE_NAME');
        $this->view->params['breadcrumbs'] = [$this->pageName];
        $this->buttons = [
            [
                'icon' => 'export',
                'label' => Yii::t('fcm/default', 'Send push'),
                'url' => ['/admin/fcm/default/send'],
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


    public function actionSend()
    {

        $this->pageName = Yii::t('app/default', 'Push message');
        $this->view->params['breadcrumbs'][] = [
            'url' => ['index'],
            'label' => Yii::t('fcm/default', 'MODULE_NAME')
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;

        $client = new \Fcm\FcmClient(Yii::$app->settings->get('fcm', 'server_key'), '');


        $model = new NotificationForm();
        if (Yii::$app->request->get('token')) {
            $model->device_id = Yii::$app->request->get('token');
        }
        $model->body = '👞 👟 🥾 🥿 👠 👡 🩰 👢 Добавлено 98 новинок\nКроссовки, Ботинки, Кеды и т.д.';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $myObjArray = ['screen' => 'NewScreen'];
                $notification = new \Fcm\Push\Notification();
                $notification->addRecipient($model->device_id);
                $notification->setTitle($model->title);
                $notification->setBody($model->body);
                //$notification->setColor('#20F037');
                //$notification->setSubtitle('sub'); //iOS only: and setBbadge
                //$notification->setSound("default");
                //->setIcon('ic_notification.png') //folder android drawable-XYdi
                $notification->addDataArray($myObjArray);
                $result = $client->send($notification);

                if ($result['success']) {
                    Yii::$app->session->setFlash("success", Yii::t('fcm/default', 'Success send push message'));
                }


            } else {
                foreach ($model->getErrors() as $error) {
                    Yii::$app->session->setFlash("error", $error);
                }
            }
            return $this->refresh();
        }


        return $this->render('send', [
            'model' => $model,
            'client' => $client,
        ]);

    }

    public function getAddonsMenu()
    {
        return [
            [
                'label' => Yii::t('app/default', 'SETTINGS'),
                'url' => array('/admin/fcm/settings'),
                'icon' => Html::icon('settings'),
            ],
        ];
    }

}
