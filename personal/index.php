<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Личные данные");
$APPLICATION->SetTitle("Личные данные");
if (!$USER->IsAuthorized()) {
    LocalRedirect('/personal/login/');
}
?>
    <section class="container-wrap lk__wrap">
        <div class="container-item lk">
            <h1 class="h1 lk__h">Личный кабинет</h1>
            <div class="lk__content-wrap">
                <? $APPLICATION->IncludeComponent("bitrix:menu", "lk", array(
                    "ALLOW_MULTI_SELECT" => "N",    // Разрешить несколько активных пунктов одновременно
                    "CHILD_MENU_TYPE" => "left",    // Тип меню для остальных уровней
                    "DELAY" => "N",    // Откладывать выполнение шаблона меню
                    "MAX_LEVEL" => "1",    // Уровень вложенности меню
                    "MENU_CACHE_GET_VARS" => array(    // Значимые переменные запроса
                        0 => "",
                    ),
                    "MENU_CACHE_TIME" => "3600",    // Время кеширования (сек.)
                    "MENU_CACHE_TYPE" => "N",    // Тип кеширования
                    "MENU_CACHE_USE_GROUPS" => "Y",    // Учитывать права доступа
                    "ROOT_MENU_TYPE" => "lk",    // Тип меню для первого уровня
                    "USE_EXT" => "N",    // Подключать файлы с именами вида .тип_меню.menu_ext.php
                ),
                    false
                ); ?>
                <div class="lk__content">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.profile",
                        "personal",
                        array(
                            "AJAX_MODE" => $arParams["AJAX_MODE_PRIVATE"],
                            "CHECK_RIGHTS" => "N",
                            "COMPONENT_TEMPLATE" => "personal",
                            "EDITABLE_EXTERNAL_AUTH_ID" => $arParams["EDITABLE_EXTERNAL_AUTH_ID"],
                            "SEND_INFO" => "N",
                            "SET_TITLE" => "N",
                            "USER_PROPERTY" => array(),
                            "USER_PROPERTY_NAME" => ""
                        ),
                        $component
                    ); ?>
                </div>
            </div>
        </div>
    </section>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>