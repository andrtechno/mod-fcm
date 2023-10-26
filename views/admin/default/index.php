<?php

use panix\engine\grid\GridView;
use panix\engine\Html;

/**
 * @var $this \yii\web\View
 */

panix\engine\assets\ClipboardAsset::register($this);


//common.clipboard
//ClipboardAsset
echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'showFooter' => true,
    'rowOptions' => ['class' => 'sortable-column'],
    'columns' => [
        'token' => [
            'format' => 'raw',
            'value' => function ($model) {
                return Html::tag('code', $model->token,['id'=>'copy-it'.$model->id]).' - '.Html::icon('copy',['class'=>'btn btn-sm btn-outline-primary coping','data-clipboard-target'=>'#copy-it'.$model->id]);
            }
        ],
        'platform',
        'created_at' => [
            'attribute' => 'created_at',
            'class' => 'panix\engine\grid\columns\jui\DatepickerColumn',
        ],
        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
            'filter' => false,
            'template' => '{send}',
            'buttons' => [
                'send' => function ($url, $model) {
                    return Html::a('Send push', ['/admin/fcm/default/send', 'token' => $model->token], ['class' => 'btn btn-sm btn-success']);
                }
            ]
        ]
    ]
]);
$this->registerJs("
    var clipboard = new ClipboardJS('.coping');
    clipboard.on('success', function (e) {
        common.notify('Скопировано!', 'success');
    });
",\yii\web\View::POS_END);



