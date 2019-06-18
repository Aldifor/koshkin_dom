<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<div class="container my-3">
    <?php if(Yii::$app->session->hasFlash('success')):?>
            <div class="alert alert-success" id='success'>
                <strong>Успешно</strong> <?=Yii::$app->session->getFlash('success')?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif;?>

        <?php if(Yii::$app->session->hasFlash('error')):?>
            <div class="alert alert-danger " id="danger">
                <strong>Ошибка!</strong>  <?=Yii::$app->session->getFlash('error')?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif;?>
    <?php $form = ActiveForm::begin(['id' => 'creat_new','options' => ['enctype/form-data']] ) ?>
        <?= $form->field($model, 'current_password')->input('password',['class'=>'form-control border-success']) ?>
        <?= $form->field($model, 'password')->input('password',['class'=>'form-control border-success']) ?>
        <?= $form->field($model, 'password_repet')->input('password',['class'=>'form-control border-success']) ?>
        <?=Html::submitButton('Сохранить', ['class' => 'btn btn-success']);?>
    <?php ActiveForm::end(); ?>
</div>
