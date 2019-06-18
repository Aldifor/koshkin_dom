 <?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use app\models\Profation;
    $status =[
        '0' => 'Нейтрал',
        '1' => 'В косе'
    ]
//  debug($cos);
?>
<div class="container mb-3">
    <?php if(!$id){?>
        <div class="title">Косники</div>
        <div class="border-success">
            <div class="row">
                <div class="col-2 tb-title border-right-0 border border-success">Ник</div>
                <div class="col-2 tb-title border-right-0 border border-success">Профа</div>
                <div class="col tb-title border-right-0 border border-success">Описание</div>
                <div class="col-2 tb-title border border-success">Статус</div>
            </div>
            <?php
                foreach ($kos as $item ){
                    ?>
                    <a href="?id=<?=$item['id']?>">
                        <div class="row border-success">
                            <div class="col-2 border border-right-0 border-top-0 border-success"><?=$item['nicname']?></div>
                            <div class="col-2 border border-right-0 border-top-0 border-success">
                                <?php
                                    foreach($prof as $item_prof){
                                        if($item['prof'] == $item_prof['id']){
                                            echo  $item_prof['prof_name'];
                                        }
                                    }
                                ?>
                            </div>
                            <div class="col  border border-right-0 border-top-0 border-success"><?=$item['text']?></div>
                            <div class="col-2 border border-top-0 border-success">
                                <?php
                                    if($item['status'] == 0){
                                        echo 'Нейтрал';
                                    }else{
                                        echo 'В косе';
                                    }
                                    $item['status']
                                ?>
                            </div>
                        </div>
                    </a>
                    <?php
                }
            ?>
        </div>

        <div class="title">Добавить косника</div>
    <?php }
        else{
    ?>
    <?php
        ?>
        <div class="title">Редактировать</div>
        <?php
        }
    ?>
    <?php $form = ActiveForm::begin(['id' => 'creat_new','options' => ['enctype/form-data']] ) ?>
            <?= $form->field($model, 'nicname')->input('text',['class'=>'form-control border-success']) ?>
            <?= $form->field($model, 'prof')->dropDownList(
                    \yii\helpers\ArrayHelper::map($prof, 'id', 'prof_name'),
                    ['class'=>'form-control border-success bg-dark']
                )
            ?>
            <?php
            if($id)
                echo $form->field($model, 'status')->dropDownList(
                        $status,
                        ['class'=>'form-control border-success bg-dark']
                    )
            ?>
            <?= $form->field($model, 'text')->textarea(['style' => 'height:10rem', 'class'=>' form-control border-success'] ) ?>

            <?php if(!$id)
                echo Html::submitButton('Добавить', ['class' => 'btn btn-success']);
            else
                echo Html::submitButton('Обновить', ['class' => 'btn btn-success']);

    ActiveForm::end() 
    ?>
</div>