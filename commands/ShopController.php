<?php

namespace panix\mod\fcm\commands;

use panix\mod\fcm\models\UsersFcm;
use panix\mod\shop\models\Product;
use panix\mod\shop\models\Supplier;
use Yii;
use panix\engine\console\controllers\ConsoleController;


/**
 * FCM push notification
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

    public function actionTest()
    {

        $notification = new \Fcm\Push\Notification();
        foreach ($this->getTokens() as $token) {
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

    /**
     * Sales products
     */
    public function actionSales()
    {

        $query = Product::find()->published()->sales();

        $brands = [];
        $categories = [];
        $discounts = (Yii::$app->hasModule('discounts')) ? Yii::$app->getModule('discounts')->discounts : false;
        if ($discounts) {
            $categoriesList = [];
            $brandsList = [];
            foreach ($discounts as $discount) {
                /** @var \panix\mod\discounts\models\Discount $discount */
                $categoriesList[] = $discount->categories;
                $brandsList[] = $discount->brands;
            }

            foreach ($categoriesList as $category) {
                foreach ($category as $item) {
                    $categories[] = $item;
                }
            }

            foreach ($brandsList as $brand) {
                foreach ($brand as $item2) {
                    $brands[] = $item2;
                }
            }
        }

        if ($brands) {
            $query->applyBrands(array_unique($brands), 'orWhere');
        }
        if ($categories) {
            $query->applyCategories(array_unique($categories), 'orWhere');
        }
        $title = 'Знижки';
        $body = '👞 👟 🥾 🥿 👠 👡 🩰 👢 Добавлено 98 новинок\nКроссовки, Ботинки, Кеды и т.д';
        $data = ['screen' => 'SalesScreen'];
        $this->push($title, $body, $data);
        echo $query->count();
    }

    /**
     * New products
     */
    public function actionNew()
    {

        $date_utc = new \DateTime("now", new \DateTimeZone("UTC"));
        $now = $date_utc->getTimestamp();

        $query = Product::find()->published()->asArray();
        $query->andWhere(['!=', "availability", Product::STATUS_OUT_STOCK]);
        //$query->andWhere(['>=', Product::tableName().'.created_at', ($date_utc->getTimestamp() - (86400 * 100))]);
        //$query->andWhere(['<=', Product::tableName().'.created_at', ($date_utc->getTimestamp() - (86400 * 99))]);


        $query->andWhere(['>=', Product::tableName() . '.created_at', strtotime('30-06-2023 00:00:00')]);
        $query->andWhere(['<=', Product::tableName() . '.created_at', strtotime('30-06-2023 23:59:59')]);

        //По поставщику
        //$query->groupBy(['supplier_id']);
        //$query->select(['*', 'count(supplier_id) as counter']);
        //$query->with(['supplier']);

        //По категории
        $query->groupBy(['main_category_id']);
        $query->select(['*', 'count(main_category_id) as counter']);
        $query->with(['mainCategory']);

        $res = $query->all();

        foreach ($res as $item) {
            //поставшик
            //echo $item['supplier']['name'] . '(' . $item['counter'] . ')' . PHP_EOL;

            //категории
            echo $item['mainCategory']['name_uk'] . '(' . $item['counter'] . ')' . PHP_EOL;
        }

        die;
        $data = ['screen' => 'NewScreen'];
        $title = 'Добавлено 98 новинок';
        $body = '👞 👟 🥾 🥿 👠 👡 🩰 👢 Добавлено 98 новинок\nКроссовки, Ботинки, Кеды и т.д';
        $this->push($title, $body, $data);
        echo $query->count();
    }

    private function getTokens()
    {
        $tokens = [];
        //error token FAKE
        $tokens[] = 'ccDr-wRIT-Cn-eCboSww4P:APA91bE6MildSU3fmFP9s7iJj8CeiI_YA7bMHitd0IxiSqxwxuxELkiTB2KRu8D4PZCP7f-HdoCDOW_ZakiRp35yc1mhfJ23LF0s5l75MWS_Yx_WPzCrC-UHJ8dcDhhcsAHYS7J4iB_z';
        $users = UsersFcm::find()->all();
        foreach ($users as $user) {
            $tokens[] = $user->token;
        }
        return $tokens;
    }

    private function push($title = '', $body = '', $data = [])
    {
        $notification = new \Fcm\Push\Notification();
        foreach ($this->getTokens() as $token) {
            $notification->addRecipient($token);
        }
        $notification->setTitle($title);
        $notification->setBody($body);
        $notification->setColor('#20F037');
        $notification->setSound("default");
        $notification->setIcon('ic_notification.png'); //folder android drawable-XYdi

        if ($data) {
            $notification->addDataArray($data);
        }

        //$notification->addData('action_url', 'https://option.com.ua/new');

        $result = $this->client->send($notification);
    }
}
