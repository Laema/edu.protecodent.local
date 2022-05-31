<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><?

ShowMessage($arParams["~AUTH_RESULT"]);

?>
<section class="container-wrap regist__wrap">
    <div class="container-item regist">
        <svg class="regist__icon" width="550" height="550">
            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#logo-min"></use>
        </svg>
        <div class="regist__body-wrap">
            <div class="regist__body">
                <h1 class="h1 regist__h"><?= $APPLICATION->showTitle(false) ?></h1>
                <form class="regist__form" name="bform" method="post" target="_top"
                      action="<?= $arResult["AUTH_URL"] ?>">
                    <?
                    if ($arResult["BACKURL"] <> '') {
                        ?>
                        <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
                        <?
                    }
                    ?>
                    <input type="hidden" name="AUTH_FORM" value="Y">
                    <input type="hidden" name="TYPE" value="SEND_PWD">

                    <input class="input" required type="text" name="USER_LOGIN" placeholder="<?= GetMessage("sys_forgot_pass_login1") ?>" value="<?= $arResult["USER_LOGIN"] ?>"/>
                    <input type="hidden" name="USER_EMAIL"/>

                    <p><? echo GetMessage("sys_forgot_pass_note_email") ?></p>

                    <? if ($arResult["PHONE_REGISTRATION"]): ?>

                        <div style="margin-top: 16px">
                            <div><b><?= GetMessage("sys_forgot_pass_phone") ?></b></div>
                            <div><input type="text" name="USER_PHONE_NUMBER"
                                        value="<?= $arResult["USER_PHONE_NUMBER"] ?>"/></div>
                            <div><? echo GetMessage("sys_forgot_pass_note_phone") ?></div>
                        </div>
                    <? endif; ?>

                    <? if ($arResult["USE_CAPTCHA"]): ?>
                        <div style="margin-top: 16px">
                            <div>
                                <input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
                                <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>"
                                     width="180" height="40" alt="CAPTCHA"/>
                            </div>
                            <div><? echo GetMessage("system_auth_captcha") ?></div>
                            <div><input type="text" name="captcha_word" maxlength="50" value=""/></div>
                        </div>
                    <? endif ?>
                    <button class="button login__form-button" type="submit"><?= GetMessage("AUTH_SEND") ?></button>
                </form>
                <div class="regist__login-linc">
                    <a href="/personal/login/"><?= GetMessage("AUTH_AUTH") ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    document.bform.onsubmit = function () {
        document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;
    };
    document.bform.USER_LOGIN.focus();
</script>
