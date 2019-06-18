<div class="col-12 light py-3">
    <div class="alert alert-success" style=" display: none;" id='success'>
        <strong>Успешно</strong> Данные обновленны.
    </div>

    <div class="alert alert-danger " style=" display: none;" id="danger">
        <strong>Ошибка!</strong> Данные не обновленны!.
    </div>
        <div class="form-group ">
        <label for="option_us">Сортировать</label>
        <select id="option_us" class="form-control form-success border-success bg-dark">
            <option selected value="0" >Все пользователи</option>
            <option value="1">Недавно зарегистрированые </option>
            <option value="2">Без допуска</option>
            <option value="5">Есть допуск </option>
            <option value="3">Учасники ГИ </option>
            <option value="4">Гости </option>
        </select>
    </div>
        <div id="us_table" class="border-success border-bottom">
        </div>
        <button class="btn btn-success m-2" id="send">Сохранить</button>
        <button class="btn btn-success m-2" id="cancell">Отмена</button>
</div>
<?php
$this->registerJsFile( '@web/js/scripts/listus_script.js', $options = ['depends'=>['yii\web\YiiAsset','yii\bootstrap\BootstrapAsset']]);
?>