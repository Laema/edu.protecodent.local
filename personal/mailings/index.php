<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Мои рассылки");
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
                    <h2 class="lk__content-h">Вы подписаны на рассылки:</h2>
                    <ul class="lk-mailing-list">
                    <?
                    if (CModule::IncludeModule("subscribe")) {
                        $rsSubscription = CSubscription::GetList(array(), array("USER_ID" => $USER->GetID()));
                        while ($arSubscription = $rsSubscription->GetNext()):
                            $rsRubric = CSubscription::GetRubricList($arSubscription['ID']);
                            if ($ar = $rsRubric->Fetch()):?>
                                <li class="lk-mailing-list__list">
                                    <div class="lk-mailing-list__text"><?=$ar['NAME']?></div>
                                    <button class="button button_ghost"
                                            data-action="clickUnsubscribe" data-sub-id="<?=$arSubscription['ID']?>">
                                        Отменить рассылку
                                    </button>
                                </li>
                            <?endif;?>
                        <?endwhile;
                    }
                    ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>