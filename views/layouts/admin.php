<?php

use yii\base\View;
use yii\helpers\Html;
use app\assets\AppAsset;

$this->title = "Кошкин дом";
AppAsset::register($this);
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
<body >
<?php $this->beginBody() ?>
    <div class="                                                                                                                                                                                                                                                                                                                                      h-100">
        <div class="container shadow">
            <div id="anchor"></div>
            <div class="img-baner w-100 align-items-center justify-content-end d-flex" >
                <img src="/img/baneritem.jpg" class="w-100" alt="">
            </div>
            <nav class="navbar navbar-expand-lg top navbar-dark bg-dark">
                <div class="justify-conent-start">
                    <button class="navbar-toggler mr-2" type="button" data-toggle="collapse" data-target="#navbarContent" 
                            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand" href="/">
                    <img src="/img/logo.png" class="rounded-circle" width="30px" hight="30px" alt="logo">
                    <span class="ml-0">Кошкин дом </span>
                    </a>
                </div>
                <div class="collapse navbar-collapse justify-content-between" id="navbarContent">
                    <ul class="navbar-nav">
                        <?php
                        foreach($this->context->navbar as $item){
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link
                                        <?php
                                            if($item['nameNav'] == $this->context->navActiv){
                                                echo 'active';
                                            }
                                        ?>"
                                        href="<?=$item['href'];?>">
                                            <?=$item['name']?>
                                        </a>
                                </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </nav>

            <div class="content row" >
                <div class="col-12">
                   <?=$content?>
                </div>
            </div>
        <?php
            include 'blocks/footer.php'
        ?>
        </div>
    </div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
