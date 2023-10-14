<?php

namespace panix\mod\fcm\models;

use Yii;
use panix\engine\CMS;
use yii\base\Model;

class NotificationForm extends \panix\engine\base\Model
{

    protected $module = 'fcm';

    public $device_id;
    public $title;
    public $body;

    public function rules()
    {
        return [
            [['device_id', 'title', 'body'], "required"],
            [['body', 'title'], 'string'],
        ];
    }


}
