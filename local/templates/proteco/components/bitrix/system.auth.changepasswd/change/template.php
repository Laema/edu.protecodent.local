<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if ($arResult["PHONE_REGISTRATION"]) {
    CJSCore::Init('phone_auth');
}
if($APPLICATION->arAuthResult["TYPE"] == 'OK'){

    if(!empty($arResult["LAST_LOGIN"]) AND !empty($arResult["USER_PASSWORD"])){
        $loginData = $USER->Login($arResult["LAST_LOGIN"], $arResult["USER_PASSWORD"], "Y");
        if($loginData){
            localRedirect('/personal/');
        }
    }
}

?>
<section class="container-wrap regist__wrap">
    <div class="container-item regist">
        <svg class="regist__icon" width="550" height="550">
            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#logo-min"></use>
        </svg>
        <div class="regist__body-wrap">
            <div class="regist__body">
                <h1 class="h1 regist__h"><?= $APPLICATION->showTitle(false) ?></h1>
                <!-- <p>Письмо для восстановления пароля отправленно на ваш адрес электронной почты.</p>
                <p>Проверьте вашу почту на наличие контрольной суммы.</p> -->
                <?
                ShowMessage($arParams["~AUTH_RESULT"]);
                ?>
                <? if ($arResult["SHOW_FORM"]): ?>

                    <form class="regist__form" method="post" action="<?=$arResult["AUTH_URL"] ?>" name="bform">
                        <input type="hidden" name="backurl" value="/personal/"/>
                        <input type="hidden" name="AUTH_FORM" value="Y">
                        <input type="hidden" name="TYPE" value="CHANGE_PWD">
                            <? if ($arResult["PHONE_REGISTRATION"]): ?>
                                <tr>
                                    <td><? echo GetMessage("sys_auth_chpass_phone_number") ?></td>
                                    <td>
                                        <input type="text"
                                               value="<?= htmlspecialcharsbx($arResult["USER_PHONE_NUMBER"]) ?>"
                                               class="bx-auth-input" disabled="disabled"/>
                                        <input type="hidden" name="USER_PHONE_NUMBER"
                                               value="<?= htmlspecialcharsbx($arResult["USER_PHONE_NUMBER"]) ?>"/>
                                    </td>
                                </tr>
                                <tr>


                                    <input type="text" name="USER_CHECKWORD" maxlength="50"
                                               value="<?= $arResult["USER_CHECKWORD"] ?>"
                                               required
                                               placeholder=""
                                               autocomplete="off"/></td>
                                </tr>
                            <? else: ?>
                                    <input type="text" name="USER_LOGIN" maxlength="50" required
                                           placeholder="<?= GetMessage("AUTH_LOGIN") ?>"
                                               value="<?= $arResult["LAST_LOGIN"] ?>" class="input"/>
                                <?
                                if ($arResult["USE_PASSWORD"]):
                                    ?>
                                    <tr>
                                        <td>
                                            <span class="starrequired">*</span><? echo GetMessage("sys_auth_changr_pass_current_pass") ?>
                                        </td>
                                        <td><input type="password" name="USER_CURRENT_PASSWORD" maxlength="255"
                                                   value="<?= $arResult["USER_CURRENT_PASSWORD"] ?>"
                                                   class="bx-auth-input" autocomplete="new-password"/></td>
                                    </tr>
                                <?
                                else:
                                    ?>
                                    <input class="input" type="text" name="USER_CHECKWORD" maxlength="50"
                                                   value="<?= $arResult["USER_CHECKWORD"] ?>"
                                                   required
                                                   placeholder="<?= GetMessage("AUTH_CHECKWORD") ?>"
                                                   autocomplete="off"/>
                                <?
                                endif
                                ?>
                            <? endif ?>
                                <input type="password" class="input" name="USER_PASSWORD" maxlength="255"
                                           value="<?= $arResult["USER_PASSWORD"] ?>"
                                           autocomplete="new-password" required
                                       placeholder="<?= GetMessage("AUTH_NEW_PASSWORD_REQ") ?>"/>
                                    <? if ($arResult["SECURE_AUTH"]): ?>
                                        <span class="bx-auth-secure" id="bx_auth_secure"
                                              title="<? echo GetMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
                                            <div class="bx-auth-secure-icon"></div>
                                        </span>
                                                                <noscript>
                                        <span class="bx-auth-secure" title="<? echo GetMessage("AUTH_NONSECURE_NOTE") ?>">
                                            <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                                        </span>
                                        </noscript>
                                        <script type="text/javascript">
                                            document.getElementById('bx_auth_secure').style.display = 'inline-block';
                                        </script>
                                    <? endif ?>
                               <input class="input" type="password" name="USER_CONFIRM_PASSWORD" maxlength="255"
                                           value="<?= $arResult["USER_CONFIRM_PASSWORD"] ?>"
                                           autocomplete="new-password" required
                                            placeholder="<?= GetMessage("AUTH_NEW_PASSWORD_CONFIRM") ?>"/>

                            <? if ($arResult["USE_CAPTCHA"]): ?>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type="hidden" name="captcha_sid"
                                               value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
                                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>"
                                             width="180" height="40" alt="CAPTCHA"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="starrequired">*</span><? echo GetMessage("system_auth_captcha") ?>
                                    </td>
                                    <td><input type="text" name="captcha_word" maxlength="50" value=""
                                               autocomplete="off"/></td>
                                </tr>
                            <? endif ?>
                            <input class="button login__form-button" type="submit" name="change_pwd" value="<?= GetMessage("AUTH_CHANGE") ?>"/>
                    </form>

                    <p><? echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]; ?></p>

                <? if ($arResult["PHONE_REGISTRATION"]): ?>

                    <script type="text/javascript">
                        new BX.PhoneAuth({
                            containerId: 'bx_chpass_resend',
                            errorContainerId: 'bx_chpass_error',
                            interval: <?=$arResult["PHONE_CODE_RESEND_INTERVAL"]?>,
                            data:
                                <?=CUtil::PhpToJSObject([
                                    'signedData' => $arResult["SIGNED_DATA"]
                                ])?>,
                            onError:
                                function (response) {
                                    var errorDiv = BX('bx_chpass_error');
                                    var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
                                    errorNode.innerHTML = '';
                                    for (var i = 0; i < response.errors.length; i++) {
                                        errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
                                    }
                                    errorDiv.style.display = '';
                                }
                        });
                    </script>

                    <div id="bx_chpass_error" style="display:none"><? ShowError("error") ?></div>

                    <div id="bx_chpass_resend"></div>

                <? endif ?>

                <? endif ?>

                <div class="regist__login-linc">
                    <a href="/personal/login/"><?= GetMessage("AUTH_AUTH") ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
