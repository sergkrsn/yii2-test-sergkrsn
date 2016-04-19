<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Notification */
/* @var $form yii\widgets\ActiveForm */
//echo Yii::$app->urlManager->createUrl(['notification/replace-params'],['id'=>2]);
?>

<div class="notification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'event_id')->dropDownList(yii\helpers\ArrayHelper::map(\app\models\Event::find()->all(), 'id', 'description'), 
                                                                                            [ 'onchange' => 'getReplaceParams(this.value)'])
    ?>    
    <!--                                                    [ 'onchange' =>'getReplaceParams("'.Yii::$app->urlManager->createUrl(['notification/replace-params']).'")']) ?>
        
                                                           [ 'onchange' =>'$.post( "'.Yii::$app->urlManager->createUrl(["notification/replace-params"]).'", 
                                                              function(data) { $("#replace_div").html(data)}']) ?>         -->

    <?= $form->field($model, 'from_user_id')->dropDownList(yii\helpers\ArrayHelper::map(app\models\User::find()->all(), 'id', 'username')) ?>    

    <?= $form->field($model, 'whom_user_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?=
    //$model->type = 'email';
    $form->field($model, 'type')->dropDownList(
            $model::getTypesDelivery(), ['options' => $model->getSelectedTypesToForm(),
        'multiple' => 'true'])
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <div>
        <p><?= Html::encode('Варианты подстановки:') ?></p>
        <div id ="replace_div"><?= Html::encode($model->getReplaceInfo())?></div>
    </div>    
    <?php ActiveForm::end(); ?>

</div>
<script>
    function getReplaceParams(id) {
        url = '?r=notification/replace-params&id=' + id;
        $.post(url,
                function (data) {
                    $("#replace_div").html(data)
                });
    }   
   
</script>