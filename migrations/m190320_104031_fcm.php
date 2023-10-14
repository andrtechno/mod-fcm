<?php

/**
 * Generation migrate by PIXELION CMS
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 *
 * Class m190320_104031_fcm
 */

use panix\engine\db\Migration;
use panix\mod\fcm\models\UsersFcm;

class m190320_104031_fcm extends Migration
{

    public function up()
    {
        $this->createTable(UsersFcm::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'token' => $this->text(),
            'platform'=>$this->string(255),
            'sdk_version' => $this->integer(),
            'created_at' => $this->integer(),

        ], $this->tableOptions);
    }

    public function down()
    {
        $this->dropTable(UsersFcm::tableName());
    }

}
