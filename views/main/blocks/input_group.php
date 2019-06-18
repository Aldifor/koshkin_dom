<div class="input_content border-success p-1 p-md-2">
    <div class="row">
        <div class="col-10 col-md-11  chat_input border border-success p-2 pt-3"
            tabindex="0" contenteditable="true"
            role="textbox" id="mes-input"
            aria-multiline="true">
        </div>
        <div id="smile_btn" class="border border-left-0 col-2 col-md-1 border-success"></div>
    </div>
    <div class="smile_conteiner mt-2 border-bottom border-success pb-1" style ="display:none">
    <div class="d-none" id="user_id" data-user="<?=$_SESSION['id']?>"></div>
    <?php
            include 'smile_hed.php';
    ?>
    <div id="smile_item" class="smile_item row pt-1 border-success"></div>

    </div>
    <div class="text-center ">
        <div class="col-3"></div>
        <button class="btn btn-primary col-6 mt-2" id="send">Отправить</button>
        <div class="col-3"></div>
    </div>
</div>