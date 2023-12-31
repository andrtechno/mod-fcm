<?php

namespace panix\mod\fcm\api;

use Yii;
use yii\base\BootstrapInterface;
use yii\rest\UrlRule;
use yii\helpers\ArrayHelper;

/**
 * Class Module
 * @package panix\mod\fcm\api
 */
class Module extends \yii\base\Module
{
    //public $controllerNamespace = 'panix\mod\shop\api\controllers';
    public $host = false;
    public $ips = false;
    public $filterClass = 'panix\mod\shop\components\FilterPro';
    public $searchAttribute = 'sku';
    public $ftpClient;
    public $ftp = false;


    public $imgSizeMedium = '400x400'; //goods list gallery,
    public $imgSizeSmall = '100x100'; //admin panel, cart email
    public $imgSizePreview = '500x500'; //catalog grid

    public function init()
    {
        parent::init();
        $this->setAliases(['@' . $this->id => $this->basePath.'/../']);
        $this->registerTranslations($this->id);
    }

    private function getTranslationsFileMap($id, $path)
    {

        $lang = Yii::$app->language;
        $result = [];
        $basePath = realpath(Yii::getAlias("{$path}/{$lang}"));

        if (is_dir($basePath)) {
            $fileList = \yii\helpers\FileHelper::findFiles($basePath, [
                'only' => ['*.php'],
                'recursive' => false
            ]);
            foreach ($fileList as $path) {
                $result[$id . '/' . basename($path, '.php')] = basename($path);
                // $result[basename($path, '.php')] = basename($path);
            }
        }
        return $result;
    }

    private function registerTranslations($id)
    {
        $path = '@' . $id . '/messages';
        $translations[$id . '/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => $path,
            'fileMap' => $this->getTranslationsFileMap($id, $path)
        ];
        $this->i18n->translations = ArrayHelper::merge($translations, $this->i18n->translations);
    }

}
