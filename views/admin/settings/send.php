<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;

/**
 * @var \panix\engine\bootstrap\ActiveForm $form
 * @var \panix\mod\fcm\models\SettingsForm $model
 */

$form = ActiveForm::begin(['id' => 'fcm-form']);

// Instantiate the push notification request object.
$notification = new \Fcm\Push\Notification();

// Enhance the notification object with our custom options.
$notification->addRecipient($deviceId)
    ->setTitle('Новое поступление')
    ->setBody("👞 👟 🥾 🥿 👠 👡 🩰 👢 Добавлено 98 новинок\nКроссовки, Ботинки, Кеды и т.д.")
    ->setColor('#20F037')
    ->setSubtitle('sub') //iOS only: and setBbadge
    ->setSound("default")
    //->setTag('test')
    //->setIcon("https://optikon.com.ua/uploads/categories_icons/home3.png")
    ->setIcon(Yii::getAlias('@fcm/home.png'))
    //->addDataArray($myObjArray)
    ->addData('action_url', 'https://option.com.ua/new');
$notification2 = $client->send($notification);

?>

