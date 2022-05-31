<?
// define ("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Восстановление пароля");
$APPLICATION->AddViewContent('hide_bread', 'style="display: none"');
?>
<? if ((isset($_GET['forgot_password']) && $_GET['forgot_password'] === 'yes') || (isset($_GET['change_password']) && $_GET['change_password'] === 'yes')): ?>
    <?
    $APPLICATION->IncludeComponent("bitrix:system.auth.changepasswd", "change", Array(
        	"AUTH" => "Y",
    		"COMPONENT_TEMPLATE" => "change",
    		"REQUIRED_FIELDS" => "",
    		"SET_TITLE" => "N",
    		"SHOW_FIELDS" => "",
    		"SUCCESS_PAGE" => "/personal/login/",
    		"USER_PROPERTY" => "",
    		"USER_PROPERTY_NAME" => "",
    		"USE_BACKURL" => "Y"
    	),
    	false
    );
?>
<? else: ?>
    <? $APPLICATION->IncludeComponent("bitrix:system.auth.forgotpasswd", "forgot", array(),
        false
    ); ?>
<? endif; ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
