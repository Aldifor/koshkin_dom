<?php
    //  debug($news);
    $post_arr = [
        '5'=>'Мастер',
        '4'=>'Маршл',
    ];
foreach($news as $post):
    include 'blocks/post.php';
endforeach;
?>

<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="del">
    <div class="modal-dialog">
        <div class="modal-header content border-success justify-content-center">
            <h4 class="modal-title" id="exampleModalLongTitle">Удалить эту новость?</h4>
        </div>
        <div class="modal-content content">
            <div class="container my-3 new text-center">
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" id="mDelNew" class="btn btn-danger">Пометить на удаление</button>
                <button type="button" class="btn btn-success" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<?php
if($news)
    if($this->context->user_root['root'] == 'admin' || $this->context->user_root['post'] == ['5'] || $this->context->user_root['post'] == '4')
        include 'blocks/modal.php';

    $this->registerJsFile( '@web/js/scripts/news_script.js', $options = ['depends'=>['yii\web\YiiAsset','yii\bootstrap\BootstrapAsset']]);
?>