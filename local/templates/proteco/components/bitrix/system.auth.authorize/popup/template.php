<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?
ShowMessage($arParams["~AUTH_RESULT"]);
ShowMessage($arResult['ERROR_MESSAGE']);
?>
<div class="popups__wrap active" data-active-block="popup1">

            <div class="popups">
                <button class="popups__close active" data-active-control="popup1">
                    <svg width="15" height="15">
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-cancel-button"></use>
                    </svg>
                </button>
                <h3  class="popups__h"><?=GetMessage("AUTH_AUTHORIZE")?></h3>
                <p style="color:red">Пользователь с таким e-mail уже есть в системе, для записи на мероприятия пожалуйста, авторизуйтесь.</p>

                <form class="popups__input-wrap" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
                    <input type="hidden" name="AUTH_FORM" value="Y" />
                    <input type="hidden" name="TYPE" value="AUTH" />
                    <?if ($arResult["BACKURL"] <> ''):?>
                        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                    <?endif?>
                    <?foreach ($arResult["POST"] as $key => $value):?>
                        <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
                    <?endforeach?>
                    <input class="input" type="email" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>"
                           placeholder="<?=GetMessage("AUTH_LOGIN")?>" required>
                    <input class="input" type="password" name="USER_PASSWORD" maxlength="255" autocomplete="off"
                           placeholder="<?=GetMessage("AUTH_PASSWORD")?>" required>
                    <input type="hidden" id="USER_REMEMBER" name="USER_REMEMBER" value="Y">
                    <button class="button login__form-button" type="submit"><?=GetMessage("AUTH_AUTHORIZE")?></button>
                    <input type="hidden" name="REGISTER[ID_EVENT]" value="<?=$_GET['ID']?>">
                </form>
                <div class="regist__login-linc">
                    <a href="<?=$arParams['FORGOT_PASSWORD_URL']?>"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
                </div>
            </div>
    <div class="popups__close-area" data-active-control="popup1"></div>
</div>

<?if($arResult["AUTH_SERVICES"]):?>
<?
$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
	array(
		"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
		"CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
		"AUTH_URL" => $arResult["AUTH_URL"],
		"POST" => $arResult["POST"],
		"SHOW_TITLES" => $arResult["FOR_INTRANET"]?'N':'Y',
		"FOR_SPLIT" => $arResult["FOR_INTRANET"]?'Y':'N',
		"AUTH_LINE" => $arResult["FOR_INTRANET"]?'N':'Y',
	),
	$component,
	array("HIDE_ICONS"=>"Y")
);
?>
<?endif?>