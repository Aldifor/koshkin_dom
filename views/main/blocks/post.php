<div class="post_block" id=<?=$post['id']?>>
    <div class="post_title d-flex <?php if($this->context->user_root['root'] == 'admin' || $this->context->user_root['post'] == '5' || $this->context->user_root['post'] == '4'){ echo 'justify-content-between';} else {echo'justify-content-center';}?> border border-success">
        <?php
            if($this->context->user_root['root'] == 'admin' || $this->context->user_root['post'] == '5' || $this->context->user_root['post'] == '4'){?>
                <div class="col-2 col-md-4 text-left"><a class="a-modal" data-toggle="modal" data-title="<?=$post['title']?>" data-id="<?=$post['id']?>" data-target="#del"><img src="/img/delete.png"></a></div>
        <?php
            }
            
        if(isset($_GET['id'])){?>
            <div class=""><?=$post['title']?></div>
        <?php }else {?>
            <div class=""><a href="/news?id=<?php echo $post['id']; if($post['deleted']){echo '&deleted';}?>"><?=$post['title']?></a></div>
        <?php }?>
        <?php
            if($this->context->user_root['root'] == 'admin' || $this->context->user_root['post'] == '5' || $this->context->user_root['post'] == '4'){?>
        <div class="col-4 text-right " data-placement="bottom" data-toggle="tooltip" class="nicname"
            title="
                <span><?=$post['name']?></span>
                <br>
                <?php
                    foreach($post_arr as $key=>$item){
                        if($post['post'] == $key){
                        ?>
                        <span>
                            <?=$item?>
                        </span>
                        <?php
                        }
                    }
                ?>

            ">
            <?=$post['nicname']?>
        </div>
        <?php
            }?>
    </div>
    <div class="post_body border border-top-0 border-bottom-0  border-success">
        <?=$post['body']?>
    </div>
    <?php
    if(($post['img']) != null){
        ?>
        <div class="post_img_cont border border-top-0 border-bottom-0  border-success">
            <img class="post_img" src="<?php echo '/uploads/' . $post['img'];?>" alt="">
        </div>
        <?php
    }
    if(isset($_GET['id'])){
    ?>
        <div class="comment_header border border-success border-bottom-0">Комментарии</div>

        <div class="comment_block border border-success border-bottom-0" style="display:none">
            <div class="comment_body  border border-success" id='comment_body'<?php if(empty($comments)){echo "style='display:none;'";}?>>
                <?php
                if($comments):
                    echo $comments;
                endif;
                ?>
            </div>
            <?php
            if(isset($_SESSION['id']) && $this->context->user_root['admit']){
                include 'input_group.php';
            }
            elseif(isset($_SESSION['id']) && !$this->context->user_root['admit']){
                echo "<div class='m-2 mb-0'>У вас нет допуска к сайту</div>";
            }
            else {
                echo "<div class='m-2 mb-0'>Для возможности комментирования Авторизуйтесь</div>";
            }
            ?>
        </div>
    <?php }else {?>
        <a href="/news?id=<?=$post['id']?>"><div class="comment_header border border-success border-bottom-0">Комментарии</div></a>
    <?php }?>
    <div class="post_end row border justify-content-between border-success">
        <div class="col-4"></div>
        <div class="col-4"></div>
        <div class="col-4 text-right" data-placement="bottom" data-toggle="tooltip" title="<?=$post['date']['t_str']?>"><?=$post['date']['d_str']?></div>
    </div>
</div>