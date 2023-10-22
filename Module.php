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

    public function getAdminMenu()
    {
        return [
            'modules' => [
                'items' => [
                    [
                        'label' => Yii::t($this->id . '/default', 'MODULE_NAME'),
                        'url' => '#',
                        'icon' => $this->icon,
                        'visible' => true,
                        'items' => [
                            [
                                'label' => Yii::t('app/default', 'Send message'),
                                'url' => ['/admin/fcm/settings/send'],
                                'icon' => 'settings',
                            ],
                            [
                                'label' => Yii::t('app/default', 'SETTINGS'),
                                'url' => ['/admin/fcm/settings'],
                                'icon' => 'settings',
                            ],

                        ]
                    ],

                ],
            ],
        ];
    }

}
