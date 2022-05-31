<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/*echo '<pre>';
print_r($GLOBALS['REGISTER_ERROR']);
echo '</pre>';*/

?>
<section class="container-wrap regist__wrap">
    <div class="container-item regist">
        <svg class="regist__icon" width="550" height="550">
            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#logo-min"></use>
        </svg>
        <div class="regist__body-wrap">
            <div class="regist__body">
                <h1 class="h1 regist__h"><? $APPLICATION->ShowTitle() ?></h1>
                <form class="regist__form" method="post" action="<?= $arResult["AUTH_URL"] ?>" name="bform"
                      enctype="multipart/form-data">
                    <input type="hidden" name="AUTH_FORM" value="Y"/>
                    <input type="hidden" name="TYPE" value="REGISTRATION"/>
                    <input class="input" type="text" name="USER_NAME" maxlength="50"
                           value="<?= $arResult["USER_NAME"] ?>"
                           placeholder="<?= GetMessage("AUTH_NAME") ?>" required>
                    <input class="input" type="text" name="WORK_COMPANY"
                           placeholder="<?= GetMessage("ORG_NAME") ?>" required>
                    <input class="input" type="email" name="USER_LOGIN" maxlength="255"
                           value="<?= $arResult["USER_EMAIL"] ?>" placeholder="<?= GetMessage("AUTH_EMAIL") ?>"
                           required>
                    <input type="hidden" name="USER_EMAIL" maxlength="50" value="<?= $arResult["USER_EMAIL"] ?>"/>
                    <input class="input" type="tel" name="" placeholder="<?= GetMessage("PHONE") ?>" required>
                    <select class="input" name="WORK_PROFILE" required>
                        <option value="" disabled selected hidden>Тип организации*</option>
                        <?foreach ($GLOBALS['ORGANIZATION_TYPES'] as $orgType):?>
                            <option value="<?=$orgType['UF_NAME']?>"><?=$orgType['UF_NAME']?></option>
                        <?endforeach;?>
                    </select>
                    <input class="input" type="password" name="USER_PASSWORD" maxlength="255"
                           placeholder="<?= GetMessage("AUTH_PASSWORD_REQ") ?>" required>
                    <input class="input" type="password" name="USER_CONFIRM_PASSWORD" maxlength="255"
                           placeholder="<?= GetMessage("AUTH_CONFIRM") ?>" required>
                    <p class="popups__user-agreement">Нажимая на кнопку, я подтверждаю, что согласен на обработку моих
                        персональных данных, а также с
                        <a href="#">Пользовательским соглашением</a>
                    </p>
                    <button class="button regist__form-button" type="submit"
                            name="Register"><?= GetMessage("AUTH_REGISTER_BTN") ?></button>
                </form>
                <div class="regist__login-linc">
                    <span>У вас уже есть аккаунт?</span>
                    <a href="<?= $arResult["AUTH_AUTH_URL"] ?>"><?= GetMessage("AUTH_AUTH") ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    const userLogin = document.querySelector('[name="USER_LOGIN"]');
    if (userLogin) {
        userLogin.addEventListener('change', event => {
            const userEmail = document.querySelector('[name="USER_EMAIL"]');
            if (userEmail) {
                userEmail.setAttribute('value', userLogin.value);
                console.log(userLogin.value)
                console.log(userEmail.value)
            }
        })
    }
</script>