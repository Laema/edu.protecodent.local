<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Спикеры");
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:news",
	"speakers",
	array(
		"ADD_ELEMENT_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "UF_CITY",
			1 => "",
		),
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FILE_404" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "1",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "UF_CITY",
			1 => "",
		),
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "8",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "ajax_nav",
		"PAGER_TITLE" => "Новости",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SEF_FOLDER" => "/speakers/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_REVIEW" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "N",
		"COMPONENT_TEMPLATE" => "speakers",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "#SECTION_CODE_PATH#/",
			"detail" => "#ELEMENT_CODE#/",
		)
	),
	false
);?>


<?$APPLICATION->IncludeComponent(
"slam:easyform",
"speakers",
array(
	"CATEGORY_EMAIL_IBLOCK_FIELD" => "FORM_EMAIL",
	"CATEGORY_EMAIL_PLACEHOLDER" => "E-mail*",
	"CATEGORY_EMAIL_TITLE" => "Ваш E-mail",
	"CATEGORY_EMAIL_TYPE" => "email",
	"CATEGORY_EMAIL_VALIDATION_ADDITIONALLY_MESSAGE" => "data-bv-emailaddress-message=\"E-mail введен некорректно\"",
	"CATEGORY_EMAIL_VALIDATION_MESSAGE" => "Обязательное поле",
	"CATEGORY_EMAIL_VALUE" => "",
	"CATEGORY_MESSAGE_IBLOCK_FIELD" => "PREVIEW_TEXT",
	"CATEGORY_MESSAGE_PLACEHOLDER" => "Комментарий",
	"CATEGORY_MESSAGE_TITLE" => "Сообщение",
	"CATEGORY_MESSAGE_TYPE" => "textarea",
	"CATEGORY_MESSAGE_VALIDATION_ADDITIONALLY_MESSAGE" => "",
	"CATEGORY_MESSAGE_VALUE" => "",
	"CATEGORY_PHONE_IBLOCK_FIELD" => "FORM_PHONE",
	"CATEGORY_PHONE_INPUTMASK" => "N",
	"CATEGORY_PHONE_INPUTMASK_TEMP" => "+7 (999) 999-9999",
	"CATEGORY_PHONE_PLACEHOLDER" => "Телефон*",
	"CATEGORY_PHONE_TITLE" => "Мобильный телефон",
	"CATEGORY_PHONE_TYPE" => "tel",
	"CATEGORY_PHONE_VALIDATION_ADDITIONALLY_MESSAGE" => "",
	"CATEGORY_PHONE_VALUE" => "",
	"CATEGORY_TITLE_IBLOCK_FIELD" => "NAME",
	"CATEGORY_TITLE_PLACEHOLDER" => "Ваше имя*",
	"CATEGORY_TITLE_TITLE" => "Ваше имя",
	"CATEGORY_TITLE_TYPE" => "text",
	"CATEGORY_TITLE_VALIDATION_ADDITIONALLY_MESSAGE" => "",
	"CATEGORY_TITLE_VALUE" => "",
	"CREATE_IBLOCK" => "",
	"CREATE_SEND_MAIL" => "",
	"DISPLAY_FIELDS" => array(
		0 => "TITLE",
		1 => "EMAIL",
		2 => "COMPANY_NAME",
		3 => "CITY",
		4 => "PHONE",
		5 => "MESSAGE",
		7 => "",
	),
	"EMAIL_BCC" => "",
	"EMAIL_FILE" => "Y",
	"EMAIL_SEND_FROM" => "N",
	"EMAIL_TO" => "",
	"ENABLE_SEND_MAIL" => "Y",
	"ERROR_TEXT" => "Произошла ошибка. Сообщение не отправлено.",
	"EVENT_MESSAGE_ID" => array(
		0 => "87",
	),
	"FIELDS_ORDER" => "TITLE,EMAIL,COMPANY_NAME,CITY,PHONE,MESSAGE",
	"FORM_AUTOCOMPLETE" => "Y",
	"FORM_ID" => "FORM10",
	"FORM_NAME" => "Стать спикером",
	"FORM_SUBTITLE" => "Отправьте нам свой кейс и мы разместим его у нас на сайте.",
	"FORM_TYPE" => "sendCase",
	"FORM_SUBMIT_VALUE" => "Отправить заявку",
	"FORM_SUBMIT_VARNING" => "Нажимая на кнопку, я подтверждаю, что согласен на обработку моих персональных данных, а также с <a target=\"_blank\" href=\"/agreement/\">Пользовательским соглашением</a>",
	"HIDE_ASTERISK" => "N",
	"HIDE_FIELD_NAME" => "N",
	"HIDE_FORMVALIDATION_TEXT" => "N",
	"IBLOCK_ID" => "18",
	"IBLOCK_TYPE" => "formresult",
	"INCLUDE_BOOTSRAP_JS" => "Y",
	"MAIL_SUBJECT_ADMIN" => "#SITE_NAME#: Сообщение из формы обратной связи",
	"OK_TEXT" => "Ваше сообщение отправлено. Мы свяжемся с вами в течение 2х часов",
	"REQUIRED_FIELDS" => array(
		0 => "TITLE",
		1 => "EMAIL",
		2 => "PHONE",
		3 => "COMPANY_NAME",
		4 => "CITY",
	),
	"SEND_AJAX" => "Y",
	"SHOW_MODAL" => "N",
	"TITLE_SHOW_MODAL" => "Спасибо!",
	"USE_BOOTSRAP_CSS" => "N",
	"USE_BOOTSRAP_JS" => "N",
	"USE_CAPTCHA" => "N",
	"USE_FORMVALIDATION_JS" => "N",
	"USE_IBLOCK_WRITE" => "Y",
	"USE_JQUERY" => "N",
	"USE_MODULE_VARNING" => "Y",
	"WIDTH_FORM" => "500px",
	"_CALLBACKS" => "",
	"COMPONENT_TEMPLATE" => "sendPopup",
	"CATEGORY_TITLE_VALIDATION_MESSAGE" => "Обязательное поле",
	"CATEGORY_PHONE_VALIDATION_MESSAGE" => "Обязательное поле",
	"CATEGORY_COMPANY_NAME_TITLE" => "Название организации",
	"CATEGORY_COMPANY_NAME_TYPE" => "text",
	"CATEGORY_COMPANY_NAME_PLACEHOLDER" => "Название организации*",
	"CATEGORY_COMPANY_NAME_VALUE" => "",
	"CATEGORY_COMPANY_NAME_VALIDATION_MESSAGE" => "Обязательное поле",
	"CATEGORY_COMPANY_NAME_VALIDATION_ADDITIONALLY_MESSAGE" => "",
	"CATEGORY_CITY_TITLE" => "Город",
	"CATEGORY_CITY_TYPE" => "text",
	"CATEGORY_CITY_VALIDATION_MESSAGE" => "Обязательное поле",
	"CATEGORY_CITY_VALIDATION_ADDITIONALLY_MESSAGE" => "",
	"CATEGORY_CITY_PLACEHOLDER" => "Город",
	"ACTIVE_ELEMENT" => "N",
	"CATEGORY_COMPANY_NAME_IBLOCK_FIELD" => "FORM_COMPANY_NAME",
	"CATEGORY_CITY_IBLOCK_FIELD" => "FORM_CITY"
),
false
);?>

<? $APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "centers_main",
    array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "FILTER_NAME" => "",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => "2",
        "IBLOCK_TYPE" => "content",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "N",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "3",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Новости",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array(
            0 => "UF_ADRES",
            1 => "",
        ),
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "ID",
        "SORT_BY2" => "SORT",
        "SORT_ORDER1" => "ASC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N",
        "COMPONENT_TEMPLATE" => "centers_main"
    ),
    false
); ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
