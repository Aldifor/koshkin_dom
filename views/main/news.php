    <?php
    $post_arr = [
        '5'=>'Мастер',
        '4'=>'Маршл',
    ];
        if($this->context->user_root['root'] == 'admin' && !isset($_GET['deleted']) && !isset($_GET['id'])){
            echo'<a href="?deleted" class="my-3 btn btn-success">Удаленные записи</a>';
            echo'<div class="title">Все новости</div>';
        }
        if(!isset($_GET['id']) && isset($_GET['deleted'])){
            echo'<a href="/news" class="my-3 btn btn-success">Назад</a>';
            echo'<div class="title">Удаленные записи</div>';
        }
    if($news){
        if (!$id){
    ?>
            <?php
            foreach($news as $post):
                ?>
                    <div class="post_block" id=<?=$post['id']?>>
                        <div class="post_title d-flex justify-content-center border border-success">
                        <?php
                            if($this->context->user_root['root'] == 'admin' || $this->context->user_root['post'] == '5'){?>
                                <div class="col-1 col-md-4 text-left"><a class="a-modal" data-toggle="modal" data-title="<?=$post['title']?>" data-id="<?=$post['id']?>" data-target="#del"><img src="/img/delete.png"></a></div>
                        <?php
                            }else{?>
                                <div class="d-none"></div>
                        <?php
                            }?>
                            <div class="col-7 col-md-4"><a href="/news?id=<?php echo $post['id']; if($post['deleted']){echo '&deleted';}?>"><?=$post['title']?></a></div>
                            <div class="col-4 text-right" data-placement="bottom" data-toggle="tooltip" title="<?=$post['date']['t_str']?>"><?=$post['date']['d_str']?></div>
                        </div>
                    </div>
                <?php
            endforeach;
        }else{
            $post = $news;
            include 'blocks/post.php';
        }
}
    ?>


<?php
if($news)
    if($this->context->user_root['root'] == 'admin' || $this->context->user_root['post'] == '5' || $this->context->user_root['post'] == '4')
        include 'blocks/modal.php';
    $this->registerJsFile( '@web/js/scripts/comment_script.js', $options = ['depends'=>['yii\web\YiiAsset','app\assets\AppAsset']]);
    $this->registerJsFile( '@web/js/scripts/news_script.js', $options = ['depends'=>['yii\web\YiiAsset','app\assets\AppAsset']]);
?>

