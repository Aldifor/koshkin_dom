 <?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use vova07\imperavi\Widget;
?>
<div class="container col-10 py-3">
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

    <?php $form = ActiveForm::begin(['id' => 'creat_new','method'=>'get','options' => ['enctype/form-data']] ) ?>
        
        <?= $form->field($model, 'title')->input('text',['class'=>'form-control border-success']) ?>

        <label class=" ">Выбрать файл</label>
        <div class="custom-file mb-2">
            <?= $form->field($model, 'img')->fileInput(['class'=>' custom-file-input  form-control '])->label('Прекрeпить изображение',['class'=>'custom-file-label form-control border-success']) ?>
        </div>
        
        <?= $form->field($model, 'body')->widget(Widget::className(),[
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 200,
                    'plugins' => [
                        // 'clips',
                        'fullscreen',
                    ],
                    // 'clips' => [
                    //     ['Lorem ipsum...', 'Lorem...'],
                    //     ['red', '<span class="label-red">red</span>'],
                    //     ['green', '<span class="label-green">green</span>'],
                    //     ['blue', '<span class="label-blue">blue</span>'],
                    // ],
                ],
            ]); ?>
        
        <div class="form-check mb-2 ">
            <input class="form-check-input" type="checkbox" name="chekVk" value="" id="Check">
            <label class="form-check-label" for="Check">
                Опубликовать в ВК
            </label>
        </div>
    <?= Html::submitButton('Опубликовать', ['class' => 'btn btn-success']) ?>
<?php
ActiveForm::end() ?>
</div>
<?php


$this->registerJsFile( '@web/js/scripts/upload_script.js', $options = ['depends'=>['yii\web\YiiAsset','yii\bootstrap\BootstrapAsset']]);
?>