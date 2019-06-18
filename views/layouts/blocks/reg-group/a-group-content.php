
<div class="border border-success module light" id="a_group">
    <?php
        if(!(isset($_SESSION['login'])))
        {
            ?>
                <div class="border-bottom border-success module-header text-center">
                    <span class>Авторизация</span>
                </div>
                <div class="modul-content text-center d-none d-md-block">
                    <span>Приветствуем тебя</span><br>
                    <span>Гость</span><br>
                    <span>В нашем дружном доме :)</span>
                </div>
                <div class="p-1 p-md-2">
                        <a type="link" href="/register" class="btn btn-success a_btn mb-1 mb-md-2">
                            Регистрация
                        </a>
                        <button type="button" data-toggle="modal" data-target="#log-modal" class="btn btn-success a_btn">
                            Войти
                        </button>
                </div>

            <?php
        }
        else{
        ?>
                <div class="border-bottom border-success module-header text-center">
                    <a href="/account"><span class>Профиль</span></a>
                </div>
                <div class="m-md-2">
                    <div class="modul-content text-center">
                        <span class="d-none d-md-block">Добро пожаловать</span>
                        <span><?=$_SESSION['nicname']?></span>
                    </div>
                </div>
                <div class="m-1 m-md-2">
                    <a href="/communication/private">
                        <button type="button" class="btn btn-primary a_btn mb-1 mb-md-2">
                            ЛС
                        </button>
                    </a>
                    <a href="/logout.php">
                        <button type="button" class="btn btn-success a_btn">
                            Выйти
                        </button>
                    </a>
                </div>
            <?php
            }
    ?>
</div>