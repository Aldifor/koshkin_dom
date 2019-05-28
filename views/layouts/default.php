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
<body> 
<?php $this->beginBody() ?>
<div class="h-100">
    <div class="container gcontainer shadow">
        <div id="anchor"></div>
        <div class="img-baner w-100 align-items-center justify-content-end d-flex" >
            <img src="/img/baneritem.jpg" class="w-100" alt="">
        </div>
        <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
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
                    if(!(isset($_SESSION['login']))){
                        ?>
                            <li class="nav-item d-sm-none">
                                <a class="nav-link light" href="#" data-toggle="modal" data-target="#log-modal">Авторизация</a>
                            </li>
                        <?php
                        }
                        else {
                        ?>
                            <li class="nav-item d-sm-none">
                                <a class="nav-link a-light" href="#" data-toggle="modal" data-target="#logout-modal">Вы зашли как: <?=$_SESSION['nicname']?></a>
                            </li>
                            
                            
                        <?php
                        }

                    foreach($this->context->navbar as $item){
                        if(!($item['nameNav'] == 'admin')){
                        ?>
                            <li class="nav-item">
                                <a class="nav-link
                                    <?php
                                        if($item['nameNav'] == $this->context->navActiv){
                                            echo 'active';
                                        }
                                    ?>"
                                    href="
                                    <?php
                                        if($item['nameNav'] != 'communication' || isset($_SESSION['id'])){
                                            echo $item['href'];
                                        }
                                        elseif($item['nameNav'] =='communication' && !isset($_SESSION['id'])){
                                            echo '#';
                                        }
                                    ?>"
                                    <?php
                                        if($item['nameNav'] =='communication' && !isset($_SESSION['id'])){
                                            echo 'data-toggle="modal" data-target="#log-modal"';
                                        }
                                    ?>
                                >
                                        <?=$item['name']?>
                                    </a>
                            </li>
                        <?php
                        }
                        if(isset($_SESSION['login'])){
                            if( $item['nameNav'] == 'admin' && ($this->context->user_root['root'] == 'admin' || $this->context->user_root['post'] == '5')){
                            ?>
                                <li class="nav-item
                                    <?php
                                        if($item['nameNav'] == $this->context->navActiv){
                                            echo 'active';
                                        }
                                    ?>"
                                >
                                    <a class="nav-link" href="<?=$item['href']?>"><?=$item['name']?></a>
                                </li>
                            <?php
                            }
                        }
                        ?>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </nav>
        <div class="content row" >
            <?php
                include 'blocks/l-block.php';
            ?>
            <div class="col-12 col-sm-9">

            <?=$content?>

            </div>
        </div>
        <?php
                include 'blocks/footer.php'
        ?>
    </div>


</div>

<?php
    if(!(isset ($_SESSION['login']))){
        include ('blocks/reg-group/reg-modal.php');
    }else{
        ?>    
        <div class="modal fade" id="logout-modal" tab-index="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog" role="document" >
                <div class="modal-content reg-modal">
                    <div class="modal-body row  modal-item d-flex justify-content-center">
                        <div class="col-2"></div>
                        <div class=" col-auto bg-trans ">
                        <div class="m-2 mx-3">
                            <a href="/account/">
                                <button type="button" data-toggle="" data-target="" class="btn btn-primary my-2 w-100">
                                    Профиль
                                </button>
                            </a>
                            <a href="/communication/private">
                                <button type="button" data-toggle="" data-target="" class="btn btn-primary my-2 w-100">
                                    ЛС
                                </button>
                            </a>
                            <a href="/logout.php">
                                <button type="button" data-toggle="" data-target="" class="btn btn-success w-100">
                                    Выйти
                                </button>
                            </a>
                        </div>
                        </div>
                        <div class="col-2"></div>
                    </div>
                    <div class="modal-footer modal-item">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<?php

$script = <<< JS
///avtoriz///////
// var regem =/.+@.+\..+/;
// function active(el){
//     document.querySelector("#modal_pas_invalid").innerHTML="";
//     el.value = "";
// }
// function checkForm(){
//     var log = document.querySelector("#modal_log").value;
//     var pas = md5(document.querySelector("#modal_pas").value);
//     var arr ;
//     if(log!="" && pas!= ""){
//         $.ajax({
//             // url: "<?= Url::to(['main/index'])?>",
//             type: "POST",
//             data: "login="+log,
//             success:function(data){
//                 data = jQuery.parseJSON(data);
//                 console.log(data);
//                 if(pas == data[0]){
//                      $.ajax({
//                             url: "/main/index.php",
//                             type: "POST",
//                             data: "login="+log,
//                             success:function(){
//                                 window.location.href = "/";
//                             }
//                     })
//                 }
//                 else{
//                     document.querySelector("#modal_pas").classList.add("is-invalid");
//                     document.querySelector("#modal_pas_invalid").innerHTML="Логин или пороль не верен";
//                 }
//             }
//         })
//     }
// }
JS;
// $this->registerJs($script,['depends' => 'yii\web\YiiAsset']);

?>
