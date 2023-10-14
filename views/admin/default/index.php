<?php
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;


use Google\ApiCore\ApiException;
use Google\Cloud\Firestore\V1beta1\Document;
use Google\Cloud\Firestore\V1beta1\FirestoreClient;
putenv("GOOGLE_APPLICATION_CREDENTIALS=" . __DIR__ . '/ssss.json');
$firestore = new FirestoreClient();

$response = $firestore->getDocument('users');



print_r($response);

Pjax::begin([
    'dataProvider' => $dataProvider
]);

echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'showFooter' => true,
    //   'footerRowOptions' => ['class' => 'text-center'],
    'rowOptions' => ['class' => 'sortable-column'],

]);

Pjax::end();
