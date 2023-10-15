<?php

namespace panix\mod\fcm\commands;

use panix\mod\fcm\models\UsersFcm;
use Yii;
use panix\engine\console\controllers\ConsoleController;


/**
 * ShopController
 * @package panix\mod\fcm\commands
 */
class ShopController extends ConsoleController
{

    public $client;

    public function __construct($id, $module, $config = [])
    {
        $this->client = new \Fcm\FcmClient(Yii::$app->settings->get('fcm', 'server_key'), '');
        parent::__construct($id, $module, $config);
    }

    public function actionNew()
    {
        $tokens = [];

        //error token FAKE
        $tokens[] = 'ccDr-wRIT-Cn-eCboSww4P:APA91bE6MildSU3fmFP9s7iJj8CeiI_YA7bMHitd0IxiSqxwxuxELkiTB2KRu8D4PZCP7f-HdoCDOW_ZakiRp35yc1mhfJ23LF0s5l75MWS_Yx_WPzCrC-UHJ8dcDhhcsAHYS7J4iB_z';

        $users = UsersFcm::find()->all();

        foreach ($users as $user) {
            $tokens[] = $user->token;

        }
        $notification = new \Fcm\Push\Notification();
        foreach ($tokens as $token) {
            $notification->addRecipient($token);
        }
        $notification->setTitle('testing');
        $notification->setBody('body');
        $notification->setColor('#20F037');
        $notification->setSound("default");
        $notification->setIcon('ic_notification.png'); //folder android drawable-XYdi
        //->addDataArray($myObjArray)
        $notification->addData('action_url', 'https://option.com.ua/new');

        $result = $this->client->send($notification);
        print_r($result);
    }

    public function actionSales()
    {

    }
}
