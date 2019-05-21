<?php
    if (isset($_SESSION['login'])){
        header('Location: /');
    }
?>
<div class="form_reg">

    <div class="row justify--center">
        <div class="col-12">
            <div class="lable">
            <span>Регистрация</span>
            </div>
            <form onsubmit = "return checkForm(this)" class="was-validated">
                <div class="light container ">
                    <label class="reg_label">Игровой ник (Копирабельно)</label>
                    <input type="text" class="form-control  bg-dark" name="nic" placeholder="Nic" required>

                    <label class="reg_label">Имя</label>
                    <input type="text" class="form-control  bg-dark "  name="name" placeholder="Name" required>

                    <label class="reg_label">Выша профа</label>
                    <div class="form-group">
                        <select class="custom-select  bg-dark"  onclick="clickProf(this)" name = "prof" required>
                        <option value="" id="0">Выбрать</option>
                        <?php
                            foreach ($prof as $item)
                                {
                            ?>
                                <option value="<?=$item['id']?>" class=""><?=$item['prof_name']?></option>
                            <?php
                                }
                        ?>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label class="reg_label">Email адрес (Логин)</label>
                        <input  id="e-mail" type="email" onblur="logtest(this)" class="form-control  bg-dark  " name="email" placeholder="E-mail" required>
                        <div id = "inval_em"class="invalid-feedback  feedback light">

                        </div>
                        <div id = "val_em" class="valid-feedback feedback">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="reg_label">Пороль</label>
                        <input id="pas" type="password" onblur="check_pass_valid(this)" class="form-control  bg-dark "  name="password" placeholder="Password" required>
                        <div id = "inval_password"class="invalid-feedback  feedback light">

                        </div>
                        <div id = "val_password" class="valid-feedback feedback">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="reg_label">Подтвердите пороль</label>
                        <input type="password" onblur="check_pass(this)" class="form-control  bg-dark " name="password_repet" placeholder="Repet Password" required>		
                        <div id = "inval_pas"class="invalid-feedback  feedback light">

                        </div>
                        <div id = "val_pas" class="valid-feedback feedback">

                        </div>
                    </div>
                        <div class="text-center  ">
                            <input type="submit" class="col-8  col-sm-4 btn btn-success"  value="Создать">
                        </div>
                </div>
            </form>
            <div class="container text-center " >
                <form action="/">
                    <input type="submit" class="btn btn- col-8  col-sm-4 my-4 mb-2" value="Отмена">
                </form>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</div>
