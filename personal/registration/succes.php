<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");
$APPLICATION->AddViewContent('hide_bread', 'style="display: none"');
?>
    <section class="container-wrap regist__wrap">
        <div class="container-item regist">
            <svg class="regist__icon" width="550" height="550">
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#logo-min"></use>
            </svg>
            <div class="regist__body-wrap">
                <div class="regist__body">
                    <svg class="regist__body-icon" width="80" height="80">
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-regist"></use>
                    </svg>
                    <h1 class="h1 regist__h">Вы успешно зарегистрировались</h1>
                    <div class="regist__text">
                        <p>Осталось подтвердить регистрацию. Письмо с ссылкой на подтверждение придет на ваш e-mail в течение 5 минут. Просто перейдите по ссылке и завершите регистрацию.</p>
                    </div>
                    <div class="regist__login-linc">
                        <span>У вас уже есть аккаунт?</span>
                        <a href="/personal/login/">Войти</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>