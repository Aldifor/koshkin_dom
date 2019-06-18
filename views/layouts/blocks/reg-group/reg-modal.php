<div class="modal fade" id="log-modal" tab-index="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog" role="document" >
        <div class="modal-content reg-modal">
            <div class="modal-header modal-item ">
                <h5 class="modal-title" id="reg-madal-title">
                </h5>
                <button class="close" aria-lable="Close"data-dismiss="modal" >
                    <span aria-hidden="true" >&times;</span>

                </button>
            </div>
            <div class="modal-body row  modal-item d-flex justify-content-center">
                <div class="col-2"></div>
                <div class=" col-auto bg-trans ">
                <div class="was-validated">
                    <div class="form-group">
                        <label for="modal_log" class="light mt-2">Логин (E-mail)</label>
                        <input type="text" class="form-control bg-dark"  id="modal_log" placeholder="Login" required>
                        <div id="modal_log_invalid" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="modal_pas" class="light mt-2">Пороль</label>
                        <input name="password" type="password" class="form-control bg-dark" id="modal_pas" onfocus="active(this)"placeholder="Password" required>                                          
                        <div id="modal_pas_invalid" class="invalid-feedback"></div>
                    </div>
                </div>
                </div>
                <div class="col-2"></div>                                                    
            </div>
            <div class="modal-footer modal-item">
                <button class="btn btn-success"  id="modal_btn_login" onclick="checkForm()">Войти</button>
                <a class="btn btn-success" href="/register">Регистрация</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div> 