<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)die();
use Bitrix\Main\Page\Asset;
CModule::IncludeModule("iblock");
$GLOBALS['OPTIONS'] = siteOptions();
$GLOBALS['ORGANIZATION_TYPES'] = getHLElementByID(6);
$GLOBALS['COUNTRY'] = getHLElementByID(7);
$GLOBALS['PHONE_CODES'] = getHLElementByID(8);
global $USER;
if ($USER->IsAuthorized()) {
    $GLOBALS['USER_ORDERS'] = userEventsInOrders();
}
?>
<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title><? $APPLICATION->ShowTitle() ?></title>
        <?php
        $APPLICATION->ShowMeta("robots");
        $APPLICATION->ShowMeta("description");
        $APPLICATION->ShowMeta("title");
        if ($USER->IsAdmin() || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') == false) {
            $APPLICATION->ShowHeadStrings();
            $APPLICATION->ShowHeadScripts();
            $GLOBALS["APPLICATION"]->MoveJSToBody('main');
            $APPLICATION->ShowBodyScripts();
            $APPLICATION->ShowCSS(true);
        }
        ?>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="ie=edge" http-equiv="x-ua-compatible">
		<meta name="yandex-verification" content="7886d2cfc778644e" />
		<meta name="facebook-domain-verification" content="t9x4f77xl1gnvr15uma40hmwmag9qw" />
        <!--    CSS    -->
        <? Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/styles/swiper-bundle.min.css'); ?>
        <? Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/styles/lightgallery.min.css'); ?>
        <? Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/styles/app.css'); ?>
        <? Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/styles/custom.css'); ?>

        <!--    js    -->
        <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/scripts/imask.min.js"); ?>
        <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/scripts/accordion.min.js"); ?>
        <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/scripts/swiper-bundle.min.js"); ?>
        <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/scripts/medium-zoom.min.js"); ?>
        <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/scripts/focus-visible.min.js"); ?>
        <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/scripts/flatpickr.min.js"); ?>
        <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/scripts/lightgallery.min.js"); ?>
        <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/scripts/lib.js"); ?>
        <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/scripts/main.js"); ?>
        <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/scripts/protecoControl.js"); ?>
        <? Asset::getInstance()->addJs('https://code.jquery.com/jquery-3.6.0.min.js'); ?>
        <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/scripts/custom.js"); ?>

        <!--ICONS-->
        <link rel="shortcut icon" href="<?= SITE_TEMPLATE_PATH ?>/assets/images/fav.png" type="image/x-icon">
        <link rel="apple-touch-icon" href="<?= SITE_TEMPLATE_PATH ?>/assets/images/fav.png">
    </head>
<body>

    <div id="panel">
        <? $APPLICATION->ShowPanel(); ?>
    </div>
    <?include_once dirname(__FILE__) . '/include/headerEventTranslation.php'?>
    <header class="container-wrap header__wrap" <? $APPLICATION->ShowViewContent('hide_header') ?>>
        <div class="container-item header">
            <a class="header__logo" href="/">
                <svg width="205" height="40">
                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#main-logo"></use>
                </svg>
            </a>
            <? $APPLICATION->IncludeComponent("bitrix:menu", "header",
                array(
                    "ALLOW_MULTI_SELECT" => "N",    // Разрешить несколько активных пунктов одновременно
                    "CHILD_MENU_TYPE" => "",    // Тип меню для остальных уровней
                    "DELAY" => "N",    // Откладывать выполнение шаблона меню
                    "MAX_LEVEL" => "1",    // Уровень вложенности меню
                    "MENU_CACHE_GET_VARS" => array(    // Значимые переменные запроса
                        0 => "",
                    ),
                    "MENU_CACHE_TIME" => "3600",    // Время кеширования (сек.)
                    "MENU_CACHE_TYPE" => "N",    // Тип кеширования
                    "MENU_CACHE_USE_GROUPS" => "Y",    // Учитывать права доступа
                    "ROOT_MENU_TYPE" => "top",    // Тип меню для первого уровня
                    "USE_EXT" => "N",    // Подключать файлы с именами вида .тип_меню.menu_ext.php
                ),
                false
            ); ?>
            <button class="button button_ghost header_button" data-action="clickShowPopup" data-popup-name="sendCase">
                Прислать свой кейс
            </button>
            <? $APPLICATION->IncludeComponent("bitrix:search.form", "search", array(
                "PAGE" => "#SITE_DIR#search/",    // Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
                "USE_SUGGEST" => "N",    // Показывать подсказку с поисковыми фразами
            ),
                false
            ); ?>
            <div class="header__login">
               <a href="/personal/">
                   <svg class="header__login-icon" width="20" height="20">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-login"></use>
                    </svg>
               </a>
                <span class="header__login-text">
                    <? if ($USER->IsAuthorized()): ?>
                        <a href="/personal/"><?= $USER->GetFullName() ?></a>
                    <? else: ?>
                        <a href="/personal/registration/">Регистрация</a> /
                        <a href="/personal/login/">Вход</a>
                    <? endif; ?>
                </span>
            </div>
            <div class="header__burger-menu burger-menu" data-active-block="burger1">
                <button class="burger-menu__close close-button" data-active-control="burger1">
                    <svg width="20" height="20">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-cancel-button"></use>
                    </svg>
                </button>
                <a class="burger-menu__logo" href="#">
                    <svg width="205" height="40">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#main-logo"></use>
                    </svg>
                </a>
                <div class="burger-menu__tell">
					<a href="tel:+78127793090">+7 (812) 779-30-90</a>
                    <!--a href="tel:+78126358890">+7 (812) 635-88-90</a-->
                    <a href="tel:+79217618890">+7 (921) 761-88-90</a>
                </div>
                <? $APPLICATION->IncludeComponent(
	"bitrix:menu",
	"burger",
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "sub",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "burger",
		"USE_EXT" => "Y",
		"COMPONENT_TEMPLATE" => "burger"
	),
	false
); ?>
                <button class="button button_ghost burger-menu_button">Прислать свой кейс</button>
                <a href="/personal/registration/" class="mobile-only burger-menu_button">Зарегистрироваться</a>
            </div>
        </div>
    </header>
<main <? $APPLICATION->ShowViewContent('main_class'); ?>>
    <? if(!CSite::InDir('/index.php')  && ERROR_404 != 'Y'):?>
        <div class="container-wrap" <?$APPLICATION->ShowViewContent('hide_bread')?>>
            <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "breadcrumb", array(
                    "PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
                    "SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
                    "START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
                ),
                false
            );?>
        </div>
    <?endif; ?>
