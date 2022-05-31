<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?php $APPLICATION->IncludeComponent("bitrix:subscribe.edit", "subscribe", array(
    "AJAX_MODE" => "Y",    // Включить режим AJAX
    "AJAX_OPTION_ADDITIONAL" => "",    // Дополнительный идентификатор
    "AJAX_OPTION_HISTORY" => "N",    // Включить эмуляцию навигации браузера
    "AJAX_OPTION_JUMP" => "N",    // Включить прокрутку к началу компонента
    "AJAX_OPTION_STYLE" => "Y",    // Включить подгрузку стилей
    "ALLOW_ANONYMOUS" => "Y",    // Разрешить анонимную подписку
    "CACHE_TIME" => "3600",    // Время кеширования (сек.)
    "CACHE_TYPE" => "A",    // Тип кеширования
    "COMPONENT_TEMPLATE" => ".default",
    "COMPOSITE_FRAME_MODE" => "A",
    "COMPOSITE_FRAME_TYPE" => "AUTO",
    "SET_TITLE" => "N",    // Устанавливать заголовок страницы
    "SHOW_AUTH_LINKS" => "N",    // Показывать ссылки на авторизацию при анонимной подписке
    "SHOW_HIDDEN" => "Y",    // Показать скрытые рубрики подписки
),
    false
); ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
