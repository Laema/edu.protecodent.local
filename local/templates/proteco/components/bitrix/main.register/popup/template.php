<?php
if($GLOBALS['REGISTER_ERROR']){
    $id = $_POST['REGISTER']['ID_EVENT'];
    header("Location:/events/?ERROR_REGISTRATION&ID=".$id);
}
if ($GLOBALS['REGISTER_SUCCESS']) {
   header('/personal/registration/succes.php');
}
?>
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?php
$length = 12;
$password = '';
$arr = array(
    'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
    'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
    'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
    '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
);
for ($i = 0; $i < $length; $i++) {
    $password .= $arr[random_int(0, count($arr) - 1)];
}
?>
<div class="popups__wrap" id="register-new-user" data-active-block="popup1">
        <div class="popups">
            <button class="popups__close active" data-active-control="popup1">
                <svg width="15" height="15">
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-cancel-button"></use>
                </svg>
            </button>
                <h3 class="popups__h">Записаться на курс</h3>
            <?if ($GLOBALS['REGISTER_ERROR']):?>
                <p style="color: red" >Пользователь с таким email уже зарегистрирован, Пожалуйста, авторизуйтесь для записи на мероприятие</p>
            <?endif;?>
                <form class="popups__input-wrap" method="post" id="webinar-registration" action="<?=$APPLICATION->GetCurPage()?>" name="regform"
                      enctype="multipart/form-data">
                    <? foreach ($arResult["SHOW_FIELDS"] as $FIELD): ?>
                        <?
                        $pls = GetMessage("REGISTER_FIELD_" . $FIELD);
                        //$pls .= $arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y" ? '*' : '';
                        $req = $arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y" ? 'required' : '';
                        switch ($FIELD) {
                            case "PASSWORD":
                                ?><input class="input" type="hidden" name="REGISTER[<?= $FIELD ?>]"
                                         value="<?= $password ?>"
                                         placeholder="<?= $pls ?>" <?= $req ?> autocomplete="off"/>
                                <?
                                break;
                            case "CONFIRM_PASSWORD":
                                ?><input class="input" type="hidden" name="REGISTER[<?= $FIELD ?>]"
                                         value="<?= $password ?>"
                                         placeholder="<?= $pls ?>" <?= $req ?> autocomplete="off"/><?
                                break;
                            case "EMAIL":
                                ?><input class="input" type="email" name="REGISTER[<?= $FIELD ?>]"
                                         value="<?= $arResult["VALUES"][$FIELD] ?>"
                                         placeholder="<?= $pls ?>" <?= $req ?>/><?
                                break;
                                case "PERSONAL_COUNTRY":
                                ?>
                                <select class="input personal-country" id="personal-country-popup" name="REGISTER[<?= $FIELD ?>]" <?= $req ?>>
                                    <option value="" disabled selected hidden><?= $pls ?></option>
                                    <?foreach ($GLOBALS['PHONE_CODES'] as $orgType):?>
                                        <option value="<?=$orgType['UF_PHONE_MASK']?>"><?=$orgType['UF_COUNTRY']?></option>
                                    <?endforeach;?>
                                </select>
                                <?
                                break;
                                case "PERSONAL_PHONE":
                                    ?><input class="input registration-phone"  id="personal-phone-popup" type="tel" name="REGISTER[<?= $FIELD ?>]"
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
                                <!-- <select class="input" name="REGISTER[PERSONAL_CITY]" <?//= $req ?>>
                                    <option value="" disabled selected hidden>Город</option>
                                    <?//oreach ($GLOBALS['COUNTRY'] as $orgType):?>
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
                    <label id="download">
                        <input type="file" value="" onChange="doDownload(this);"/>
                    </label>
                    <input type="text" id="payment-check" name="PAYMENT_CHECK"  value="" style="display:none;">
                    <?php
                        $referrer = $_GET['referrer'];
                    ?>
                    <input type="hidden" name="UF_REFERRER" value="<?=(!empty($referrer)? $referrer : ''); ?>">
                    <input type="hidden" id="register-form-event-id" name="REGISTER[ID_EVENT]">
                    <p class="popups__user-agreement">Нажимая на кнопку, я подтверждаю, что согласен на обработку
                        моих персональных данных, а также с <a href="<?=$GLOBALS['OPTIONS']['UF_AGREEMENT_URL']['VALUE']?>">Пользовательским соглашением</a></p>
                    <input class="button popups__button" type="submit" name="register_submit_button"
                           value="<?= GetMessage("AUTH_REGISTER") ?>"/>
                    <input type="hidden">
                    <div class="regist__login-linc">
                        <span>У вас уже есть аккаунт?</span>
                        <a href="/personal/login/">Войти</a>
                        <a href="/personal/forgot/">Забыли пароль?</a>
                    </div>
                </form>
<!--                <div class="regist__login-linc"><span>У вас уже есть аккаунт?</span>-->
<!--                    <a href="/personal/login/">Войти</a>-->
<!--                </div>-->
        </div>
    <div class="popups__close-area active" data-active-control="popup1"></div>
</div>
<? if ($APPLICATION->GetCurPage() == '/events/') {
    $selector = '.event-card__bot .button';
} else {
    $selector = '.event-page__head-button-wrap .button';
}?>
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
    let events = document.querySelectorAll("<?=$selector?>");
    for (let i = 0; i < events.length; i++) {
        events[i].addEventListener('click', event => {
            const idEvent = document.querySelector('[name="REGISTER[ID_EVENT]"]');
            if (idEvent) {
                idEvent.setAttribute('value', events[i].getAttribute('data-event-id'));
            }
        })
    }
</script>
