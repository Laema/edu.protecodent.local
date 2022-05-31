<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 * @global CUser $USER
 * @global CMain $APPLICATION
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>
<? if ($GLOBALS['REGISTER_SUCCESS']) {
    LocalRedirect('/personal/registration/succes.php');
} ?>
<section class="container-wrap regist__wrap">
    <div class="container-item regist">
        <svg class="regist__icon" width="550" height="550">
            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#logo-min"></use>
        </svg>
        <div class="regist__body-wrap">
            <div class="regist__body">
                <h1 class="h1 regist__h"><? $APPLICATION->ShowTitle() ?></h1>
                <form class="regist__form" method="post" action="<?= POST_FORM_ACTION_URI ?>" name="regform"
                      enctype="multipart/form-data">
                    <?if ($GLOBALS['REGISTER_ERROR']):?>
                        <p style="color: red"><?=$GLOBALS['REGISTER_ERROR']?></p>
                    <?endif;?>

                    <? foreach ($arResult["SHOW_FIELDS"] as $FIELD): ?>
                        <?
                        $pls = GetMessage("REGISTER_FIELD_" . $FIELD);
                        //$pls .= $arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y" ? '*' : '';
                        $req = $arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y" ? 'required' : '';
                        switch ($FIELD) {
                            case "PASSWORD":
                                ?><input class="input" type="password" name="REGISTER[<?= $FIELD ?>]"
                                         value="<?= $arResult["VALUES"][$FIELD] ?>"
                                         placeholder="<?= $pls ?>" <?= $req ?> autocomplete="off"/>
                                <?
                                break;
                            case "CONFIRM_PASSWORD":
                                ?><input class="input" type="password" name="REGISTER[<?= $FIELD ?>]"
                                         value="<?= $arResult["VALUES"][$FIELD] ?>"
                                         placeholder="<?= $pls ?>" <?= $req ?> autocomplete="off"/><?
                                break;
                            case "EMAIL":
                                ?><input class="input" type="email" name="REGISTER[<?= $FIELD ?>]"
                                         value="<?= $arResult["VALUES"][$FIELD] ?>"
                                         placeholder="<?= $pls ?>" <?= $req ?>/>

                                         <?
                                break;
                            case "PERSONAL_COUNTRY":
                            ?>
                            <select class="input personal-country" id="personal-country" name="REGISTER[<?= $FIELD ?>]" <?= $req ?>>
                                <option value="" disabled selected hidden><?= $pls ?></option>
                                <?foreach ($GLOBALS['PHONE_CODES'] as $orgType):?>
                                    <option value="<?=$orgType['UF_PHONE_MASK']?>"><?=$orgType['UF_COUNTRY']?></option>
                                <?endforeach;?>
                            </select>
                            <?
                            break;

                            case "PERSONAL_PHONE":
                                ?><input class="input registration-phone"  id="personal-phone" type="tel" name="REGISTER[<?= $FIELD ?>]"
                                         value="<?= $arResult["VALUES"][$FIELD] ?>"
                                         placeholder="<?= $pls ?>" <?= $req ?>/><?
                                break;
                            case "LOGIN":
                                ?><input class="input" type="hidden" name="REGISTER[<?= $FIELD ?>]"
                                         value="<?= $arResult["VALUES"][$FIELD] ?>"/><?
                                break;
                            case "WORK_PROFILE":
                                ?>
                                <select class="input" name="REGISTER[<?= $FIELD ?>]" <?= $req ?>>
                                    <option value="" disabled selected hidden><?= $pls ?></option>
                                    <?foreach ($GLOBALS['ORGANIZATION_TYPES'] as $orgType):?>
                                        <option value="<?=$orgType['UF_NAME']?>"><?=$orgType['UF_NAME']?></option>
                                    <?endforeach;?>
                                </select>
                                <?
                                break;
                            case "PERSONAL_CITY":
                                ?>
                                <input class="input" type="text" name="REGISTER[PERSONAL_CITY]"
                                         value="<?= $arResult["VALUES"][$FIELD] ?>"
                                         placeholder="<?= $pls ?>" <?= $req ?>/>

                                <!-- <select class="input" name="REGISTER[PERSONAL_CITY]" <?= $req ?>>
                                    <option value="" disabled selected hidden>Город</option>
                                    <?//foreach ($GLOBALS['COUNTRY'] as $orgType):?>
                                        <option value="<?//=$orgType['UF_TOWN']?>"><?//=$orgType['UF_TOWN']?></option>
                                    <?//endforeach;?>
                                </select> -->
                                <?
                                break;
                            default:
                                ?><input class="input" type="text" name="REGISTER[<?= $FIELD ?>]"
                                         value="<?= $arResult["VALUES"][$FIELD] ?>"
                                         placeholder="<?= $pls ?>" <?= $req ?> /><?
                        }
                        ?>
                    <? endforeach ?>
                    <p class="popups__user-agreement">Нажимая на кнопку, я подтверждаю, что согласен на обработку
                        моих персональных данных, а также с <a href="<?=$GLOBALS['OPTIONS']['UF_AGREEMENT_URL']['VALUE']?>">Пользовательским соглашением</a></p>
                    <input class="button regist__form-button" type="submit" name="register_submit_button"
                           value="<?= GetMessage("AUTH_REGISTER") ?>"/>
                </form>
                <div class="regist__login-linc"><span>У вас уже есть аккаунт?</span>
                    <a href="/personal/login/">Войти</a>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    const userEmail = document.querySelector('[name="REGISTER[EMAIL]"]');
    if (userEmail) {
        userEmail.addEventListener('change', event => {
            const userLogin = document.querySelector('[name="REGISTER[LOGIN]"]');
            if (userLogin) {
                userLogin.setAttribute('value', userEmail.value);
            }
        })
    }
</script>
