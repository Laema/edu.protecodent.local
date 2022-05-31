<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");
//if (!$USER->IsAdmin()):
    if ($USER->IsAuthorized()) {
        LocalRedirect('/personal/');
    }
//endif;
$APPLICATION->AddViewContent('hide_bread', 'style="display: none"');
?>
<?$APPLICATION->IncludeComponent("bitrix:main.register", "reg", Array(
	"AUTH" => "N",	// Автоматически авторизовать пользователей
		"REQUIRED_FIELDS" => array(	// Поля, обязательные для заполнения
			0 => "EMAIL",
			1 => "NAME",
			2 => "PERSONAL_PHONE",
			3 => "WORK_COMPANY",
			4 => "WORK_PROFILE",
			5 => "PERSONAL_CITY",
		),
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"SHOW_FIELDS" => array(	// Поля, которые показывать в форме
			0 => "EMAIL",
			1 => "NAME",
			2 => "PERSONAL_PHONE",
			3 => "WORK_COMPANY",
			4 => "WORK_PROFILE",
			5 => "PERSONAL_CITY",
		),
		"SUCCESS_PAGE" => "",	// Страница окончания регистрации
		"USER_PROPERTY" => "",	// Показывать доп. свойства
		"USER_PROPERTY_NAME" => "",	// Название блока пользовательских свойств
		"USE_BACKURL" => "Y",	// Отправлять пользователя по обратной ссылке, если она есть
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
<?/*$APPLICATION->IncludeComponent(
	"bitrix:system.auth.registration",
	"reg",
	Array(
		"AUTH" => "Y",
		"AUTH_URL" => "/personal/login/",
		"COMPONENT_TEMPLATE" => "reg",
		"REQUIRED_FIELDS" => "",
		"SET_TITLE" => "N",
		"SHOW_FIELDS" => "",
		"SUCCESS_PAGE" => "/personal/",
		"USER_PROPERTY" => "",
		"USER_PROPERTY_NAME" => "",
		"USE_BACKURL" => "Y",
		"SHOW_ERRORS" => "Y"
	),
	false
);*/?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>