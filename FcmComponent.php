<?php

namespace panix\mod\fcm;

use panix\engine\CMS;
use panix\mod\fcm\models\UsersFcm;
use Yii;
use yii\base\Component;
use Fcm\Push\Notification;

class FcmComponent extends Component
{
    public $tokens = [];
    protected $client;
    protected $push;

    public function __construct($config = [])
    {
        $this->client = new \Fcm\FcmClient(Yii::$app->settings->get('fcm', 'server_key'), '');
        $this->push = new Notification();
        $this->push->setColor('#20F037');
        $this->push->setSound("default");
        $this->push->setIcon('ic_notification.png');
        parent::__construct($config);

    }

    public function allTokens()
    {
        foreach ($this->getTokens() as $token) {
            $this->push->addRecipient($token);
        }
        return $this->push;
    }

    public function privateTokens()
    {
        $tokens = Yii::$app->settings->get('fcm', 'tokens');
        foreach ($tokens as $token) {
            $this->push->addRecipient($token);
        }
        return $this->push;
    }

    protected function getTokens()
    {

        $users = UsersFcm::find()->all();
        foreach ($users as $user) {
            $this->tokens[] = $user->token;
        }
        return $this->tokens;
    }

    public function send($notification)
    {
        return $this->client->send($notification);
    }
}
