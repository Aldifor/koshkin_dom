<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="del">
    <div class="modal-dialog">
        <div class="modal-header content border-success justify-content-center">
            <h4 class="modal-title" id="exampleModalLongTitle">Удалить эту новость?</h4>
        </div>
        <div class="modal-content content">
            <div class="container my-3 new text-center">
            </div>
            <div class="modal-footer justify-content-center border-0">
                <?php
                    if (isset($_GET['deleted']) || $news[0]['deleted']){
                        echo    '<button type="button" id="delNew" class="btn btn-danger">Удалить</button>';
                        echo    '<button type="button" id="restoreNew" class="btn btn-secondary">Востановить</button>';
                    }
                    if (!isset($_GET['deleted']) && !$news[0]['deleted']){
                        echo '<button type="button" id="mDelNew" class="btn btn-danger">Пометить на удаление</button>';
                    }
                ?>
                <button type="button" class="btn btn-success" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>