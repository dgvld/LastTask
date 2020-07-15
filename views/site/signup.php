<h1>Регистрация</h1>
<?php
use \yii\widgets\ActiveForm;
use yii\captcha\Captcha;
?>
<?php
    $form = ActiveForm::begin(['class'=>'form-horizontal']);
?>
<?= $form->field($model,'username')->textInput(['autofocus'=>true]) ?>

<?= $form->field($model,'email')->textInput() ?>

<?= $form->field($model,'password')->passwordInput()?>

<?= $form->field($model,'password_repeat')->passwordInput()?>

<?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
    'mask' => '9-999-999-9999',
]) ?>

<?= $form->field($model, 'date_create')->textInput() ?>
<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
]) ?>


    <div>

    <button type="submit" class="btn btn-primary">Submit</button>
</div>

<?php
    ActiveForm::end();
?>
