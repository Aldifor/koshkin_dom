<?php
    use yii\base\View;
    use yii\helpers\Html;
    use app\assets\RegisterAsset;

    $this->title = "Кошкин дом";
    RegisterAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?=$this->title?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="container-fluid light  " >
	<div class="container col-12 col-md-10">
        <?=$content?>
    <?php
            include 'blocks/footer.php'
    ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>