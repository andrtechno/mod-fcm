<?php

namespace panix\mod\fcm\models;

use Yii;
use panix\engine\CMS;
use panix\engine\SettingsModel;

class SettingsForm extends SettingsModel
{

    public static $category = 'fcm';
    protected $module = 'fcm';

    public $server_key;
    public $sender_id;

    public function rules()
    {
        return [
            [['server_key'], "required"],
            [['sender_id'], 'string'],
        ];
    }


    /**
     * @inheritdoc
     */
    public static function defaultSettings()
    {
        return [
            'server_key' => '',
            'sender_id' => '',
        ];
    }


}
