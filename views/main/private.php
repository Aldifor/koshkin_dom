<?php
?>
<div class="dropdown mt-3">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Список пользователей
    </button>
    <div class="dropdown-menu us_list content" id="ulm" aria-labelledby="dropdownMenuButton">
        <?php
        foreach($us as $item){
            if($item['id'] != $_SESSION['id']){
                ?>
                    <a href="/communication/private?id=<?=$item['id']?>">
                        <div id="<?=$item['id']?>"class="us_block border-success"data-toggle="tooltip" title='
                            <img class="prof_icon" src="<?=$item['prof_icon']?>">
                            <br>
                                <span><?=$item['name']?></span>
                                <br>
                                <?php
                                if($item['party']){
                                    ?>
                                    <span><?=$item['post']?></span>
                                    <?php
                                }
                                elseif(!($item['party'])){
                                    ?>
                                    <span>Гость</span>
                                    <?php
                                }
                            ?>
                        '>
                            <?=$item['nicname']?>
                        </div>
                    </a>

                <?php
            }
        }
    ?>
    </div>
    </div>

<div class="chat_body my-3">
    <div class="border border-success chat_header">
        <span>
            <?php if(!(isset($_GET['id']))){

                echo 'Сообщения';

            }
            else foreach ($us as $item){
                if($item['id'] == $_GET['id']){
                    ?>
                        <div id="<?=$item['id']?>"class=" border-success"data-toggle="tooltip" title='
                        <img class="prof_icon" src="<?=$item['prof_icon']?>">
                        <br>
                            <span><?=$item['name']?></span>
                            <br>
                            <?php
                            if($item['party']){
                                ?>
                                <span><?=$item['post']?></span>
                                <?php
                            }
                            elseif(!($item['party'])){
                                ?>
                                <span>Гость</span>
                                <?php
                            }
                        ?>
                        '>
                            <?=$item['nicname']?>
                        </div>
                    <?php
                }
            }
            ?></span>
    </div>
    <div class="chat_content border-top-0 border border-success">
        <div id="outmessage" <?php if($_GET['id']){echo 'class="border-bottom border-success"';}?>>

        </div>
        <?php
        if(isset($_GET['id'])){

            include 'blocks/input_group.php';

        }else{
            echo'<div class="d-none" id="user_id" data-user="'.$_SESSION["id"].'"></div>';
        }
        ?>
    </div>
</div>
<?php
    $this->registerJsFile( '@web/js/scripts/chat_script.js', $options = ['depends'=>['yii\web\YiiAsset','yii\bootstrap\BootstrapAsset']]);
?>
