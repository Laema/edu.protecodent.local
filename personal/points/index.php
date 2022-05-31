<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Мои баллы");
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
                    <div class="lk-ball-total__wrap">
                        <span class="lk-ball-total__text">У вас есть:</span>
                        <span class="lk-ball-total__number"><?=getUserBonuses($USER->GetID())?> баллов</span>
                    </div>
                    <ul class="lk-ball-list">
                        <li class="lk-ball-list__item">
                            <div class="lk-ball-list__text">Материал стоматологический композитный «Estelite». Набор Estelite Sigma Quick Syringe System Kit,  9 шприцев</div>
                            <div class="lk-ball-list__number">500 баллов</div><a class="button lk-ball-list__button" href="#">Запросить</a>
                        </li>
                        <li class="lk-ball-list__item">
                            <div class="lk-ball-list__text">Материал стоматологический композитный «Estelite». Набор Estelite Sigma Quick Syringe System Kit,  9 шприцев</div>
                            <div class="lk-ball-list__number">700 баллов</div><a class="button lk-ball-list__button" href="#">Запросить</a>
                        </li>
                        <li class="lk-ball-list__item">
                            <div class="lk-ball-list__text">Материал стоматологический композитный «Estelite». Набор Estelite Sigma Quick Syringe System Kit,  9 шприцев</div>
                            <div class="lk-ball-list__number">1000 баллов</div><a class="button lk-ball-list__button" href="#">Запросить</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>