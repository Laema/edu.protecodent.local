<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?
ShowMessage($arParams["~AUTH_RESULT"]);
ShowMessage($arResult['ERROR_MESSAGE']);
?>

<section class="container-wrap regist__wrap">
    <div class="container-item regist">
        <svg class="regist__icon" width="550" height="550">
            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#logo-min"></use>
        </svg>
        <div class="regist__body-wrap">
            <div class="regist__body">
                <h1 class="h1 regist__h"><?=GetMessage("AUTH_AUTHORIZE")?></h1>
                <form class="regist__form" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
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
                </form>
                <div class="">
                    <p>У меня нет аккаунта. Хочу <a href="/personal/registration/">зарегистрироваться</a></p>
                    <a href="<?=$arParams['FORGOT_PASSWORD_URL']?>"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
                </div>
            </div>
        </div>
    </div>
</section>

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
