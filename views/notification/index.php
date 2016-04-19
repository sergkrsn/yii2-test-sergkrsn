<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Notification', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'name',
            //'event_id',
            [
                'label' => 'event',
                'class' => 'yii\grid\DataColumn',
                'value' => function ($data) {
                    return $data->getEvent()->One()->getDescription();
                },
            ],
            //'from_user_id',
            [
                'label' => 'from user',
                'class' => 'yii\grid\DataColumn',
                'value' => function ($data) {
                    return $data->getUserFromName();
                },
            ],
            //'whom_user_id',
            [
                'label' => 'whom user',
                'class' => 'yii\grid\DataColumn',
                'value' => function ($data) {                    
                        return $data->getUserWhomName();                    
                },
            ],            
            'title',
            'description',
            'type',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
