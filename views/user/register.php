<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\user */

$this->title = 'Register User';
//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formRegister', [
        'model' => $model,
    ]) ?>

</div>
