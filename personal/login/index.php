<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");
//if (!$USER->IsAdmin()):
    if ($USER->IsAuthorized()) {
        LocalRedirect('/personal/');
    }
//endif;
$APPLICATION->AddViewContent('hide_bread', 'style="display: none"');
?>
<?$APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "login", Array(
	"FORGOT_PASSWORD_URL" => "/personal/forgot/",
		"PROFILE_URL" => "/personal/",
		"REGISTER_URL" => "/personal/registration/",
		"SHOW_ERRORS" => "Y",
		"AUTH_SERVICES" => "Y"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>