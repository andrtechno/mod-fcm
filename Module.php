<?php

namespace panix\mod\fcm;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\web\GroupUrlRule;
use panix\engine\WebModule;
use panix\mod\user\models\forms\SettingsForm;
use app\web\themes\dashboard\sidebar\BackendNav;

/**
 * Class Module
 * @package panix\mod\fcm
 *
 * @property array|string|null $loginRedirect
 * @property boolean $useEmail
 */
class Module extends WebModule implements BootstrapInterface
{
    public $icon = 'users';


    public function bootstrap($app)
    {
        $config = $app->settings->get($this->id);
        // add rules for admin/copy/auth controllers
        $groupUrlRule = new GroupUrlRule([
            'prefix' => $this->id,
            'rules' => [
                'profile/<id:\d+>' => 'default/view',
                '<controller:(admin|copy|auth)>' => '<controller>',
                '<controller:(admin|copy|auth)>/<action:\w+>' => '<controller>/<action>',
                '<action:[0-9a-zA-Z\-]+>/authclient/<authclient:[0-9a-zA-Z\-]+>' => 'default/<action>',
                '<action:[0-9a-zA-Z\-]+>' => 'default/<action>',
            ],
        ]);
        $app->getUrlManager()->addRules($groupUrlRule->rules, false);

    }


}
