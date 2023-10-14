<?php

use panix\engine\grid\GridView;
use yii\helpers\Html;


echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'showFooter' => true,
    //   'footerRowOptions' => ['class' => 'text-center'],
    'rowOptions' => ['class' => 'sortable-column'],
    'columns' => [
        'token',
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
                    return Html::a('Send', ['/admin/fcm/settings/send', 'token' => $model->token], ['class' => 'btn btn-sm btn-success']);
                }
            ]
        ]
    ]
]);


