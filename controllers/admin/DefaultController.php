<?php

namespace panix\mod\fcm\controllers\admin;

use panix\mod\chatgpt\models\ChatGPTSearch;
use Yii;
use panix\mod\chatgpt\models\ChatGPT;
use panix\engine\controllers\AdminController;

class DefaultController extends AdminController
{

    public function actions()
    {
        return [
            'switch' => [
                'class' => \panix\engine\actions\SwitchAction::class,
                'modelClass' => ChatGPT::class,
            ],
            'delete' => [
                'class' => \panix\engine\actions\DeleteAction::class,
                'modelClass' => ChatGPT::class,
            ],
        ];
    }

    /**
     * Display banner list.
     */
    public function actionIndex()
    {
        $this->pageName = Yii::t('chatgpt/default', 'MODULE_NAME');
        $this->view->params['breadcrumbs'] = [$this->pageName];

        /*$searchModel = new ChatGPTSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        if (Yii::$app->user->can("/{$this->module->id}/{$this->id}/*") || Yii::$app->user->can("/{$this->module->id}/{$this->id}/create")) {
            $this->buttons = [
                [
                    'label' => Yii::t('chatgpt/ChatGPT', 'CREATE_BANNER'),
                    'url' => ['create'],
                    'icon' => 'add',
                    'options' => ['class' => 'btn btn-success']
                ]
            ];
        }*/
        return $this->render('index', [
            //'dataProvider' => $dataProvider,
            //'searchModel' => $searchModel,
        ]);

    }

    public function actionUpdate($id = false)
    {
        $model = ChatGPT::findModel($id);
        $isNew = $model->isNewRecord;
        $this->pageName = ($isNew) ? $model::t('CREATE_BANNER') : $model::t('UPDATE_BANNER');

        $this->view->params['breadcrumbs'] = [
            [
                'label' => Yii::t('chatgpt/default', 'MODULE_NAME'),
                'url' => ['index']
            ],
            $this->pageName
        ];

        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $model->save();
            return $this->redirectPage($isNew, $post);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionCreate()
    {
        return $this->actionUpdate(false);
    }
}
