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
            //[['out_stock_delete', 'brand', 'tm'], 'boolean'],
            //['apikey', 'match', 'pattern' => "/^[a-zA-Z0-9\._\-]+$/u"],
            //['hook_key', 'match', 'pattern' => "/^[a-zA-Z0-9]+$/u", 'message' => 'Только буквы и цифры'],
            // [['categories_shoes'], 'safe'],
            //[['bags_type'], 'default', 'value' => ''], //,'categories_shoes'
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
