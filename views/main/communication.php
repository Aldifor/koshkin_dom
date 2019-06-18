<?php
if($this->context->user_root['is_party']){
    if($_GET['type']  == 'general'){

        ?>
            <a href="?type=gild"><button class="btn btn-success mt-3" name = "chats" id="clan_chat">В Клановый чат</button></a>
        <?php
    }else{
        ?>
            <a href="?type=general"><button class="btn btn-success mt-3" name = "chats" id="clan_chat">В Общий чат</button></a>
        <?php
    }
}
?>
<div class="chat_body my-3">
<div class="border border-success chat_header "> Общий чат</div>
    <div class="chat_content border-top-0 border border-success">
        <div id="outmessage" class="border-bottom border-success"></div>
        <?php
            include 'blocks/input_group.php';
        ?>
    </div>
</div>
<?php
$this->registerJsFile( '@web/js/scripts/chat_script.js', $options = ['depends'=>['yii\web\YiiAsset','app\assets\AppAsset']]);
?>
<!-- <script src="/public/scripts/chat_script.js"></script> -->
