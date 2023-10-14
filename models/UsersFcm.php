<?php

namespace panix\mod\fcm\models;

use Yii;
use panix\mod\contacts\models\MarkersQuery;
use panix\engine\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * Class UsersFcm
 *
 * @property integer $id
 * @property string $token
 *
 * @package panix\mod\fcm\models
 */
class UsersFcm extends ActiveRecord
{

    const MODULE_ID = 'fcm';

    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%fcm_users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token'], 'required'],
            [['platform'], 'string'],
            [['sdk_version'], 'integer'],
        ];
    }

}
