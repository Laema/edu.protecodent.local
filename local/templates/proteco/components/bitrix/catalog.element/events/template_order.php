<?php
use Bitrix\Sale;
 ?>
<div class="container-wrap event-page__main">
    <div class="container-item event-page">
        <h1 class="event-page__h1">Вы записались на мероприятие:</h1>
        <div class="event-card-l event-page__event-card-l">
            <div class="event-card-l__left <?=$eventType['UF_LINK']?>">
                <svg class="event-card-l__left-icon" width="45" height="45">
                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#<?= $eventType['UF_DESCRIPTION'] ?>"></use>
                </svg>
                <span class="event-card-l__left-name"><?= $eventType['UF_NAME'] ?></span>
            </div>
            <div class="event-card-l__body">
                <div class="event-card-l__date-wrap">
                    <div class="event-card-l__date-name"><?= $eventType['UF_NAME'] ?></div>
                    <? if ($props['UF_DATE_ACTIVE']['VALUE']): ?>
                        <div class="event-card-l__date">
                            <svg width="17" height="17">
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-date"></use>
                            </svg>
                            <span><?= FormatDate("d F Y", MakeTimeStamp($props['UF_DATE_ACTIVE']['VALUE'])) ?></span>
                        </div>
                    <? endif; ?>
                    <? if ($ufTimeB || $ufTimeA):
                        ?>
                        <div class="event-card-l__date">
                            <svg width="17" height="17">
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-time"></use>
                            </svg>
                            <span><?= $ufTimeB ? 'с ' . $ufTimeB : '' ?> <?= $ufTimeA ? 'до ' . $ufTimeA : '' ?></span>
                        </div>
                    <? endif; ?>
                </div>
                <h3 class="event-card-l__body-h"><?= $arResult['NAME'] ?></h3>
                <div class="event-card-l__body-name">
                    <?= $spikerFields['NAME'] ?> <?= $spikerProps['UF_CITY']['VALUE'] ? '(' . $spikerProps['UF_CITY']['VALUE'] . ')' : '' ?>
                </div>
                <div class="event-card-l__body-text">
                    <p><?= $spikerFields['~PREVIEW_TEXT'] ?></p>
                </div>
            </div>
            <div class="event-card-l__button-wrap">
                <?if ($userOrder['STATUS'] === 'NEED_PAY' && empty($props['UF_IS_ONLINE_PAY_DISABLED']['VALUE'])):?>
                    <?php
                        $orderObj = Sale\Order::load($_GET['ORDER_ID']);
                        $paymentCollection = $orderObj->getPaymentCollection();
                        $payment = $paymentCollection[0];
                        $service = Sale\PaySystem\Manager::getObjectById($payment->getPaymentSystemId());
                        $context = \Bitrix\Main\Application::getInstance()->getContext();
                        $service->initiatePay($payment, $context->getRequest());
                     ?>
                <?endif;?>
                <?=$colleagBtn?>
                <a href="/ics.php?TITLE=<?=$arResult['NAME']?>&DESCRIPTION=<?=$spikerFields['~PREVIEW_TEXT']?>&START=<?=$arResult['PROPERTIES']['UF_TIME_BEF']['VALUE']?>&END=<?=$arResult['PROPERTIES']['UF_TIME_AFT']['VALUE']?>&LOC=<?=$arResult['PROPERTIES']['UF_LOCATION']['VALUE']?>&URL=<?=$arResult['DETAIL_PAGE_URL']?>" class="button button_ghost-double">Добавить уведомление <br>в календарь</a>
                <?php if(!empty($props['UF_IS_ONLINE_PAY_DISABLED']['VALUE'])) : ?>
                    <div class="event-page__block-pay">
                        Регистрационный взнос: <?=printApart($props['UF_REGISTER_PAY']['VALUE'])?>  ₽
                        <p>Для оплаты свяжитесь с организатором.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <? if ($props['UF_ORGANIZER']['VALUE']  && !empty($props['UF_IS_ONLINE_PAY_DISABLED']['VALUE'])):
            $organizerArr = getHLElementByName($props['UF_ORGANIZER']['USER_TYPE_SETTINGS']['TABLE_NAME']);
        ?>
            <div class="event-page__block">
                <h3 class="event-page__block-h event-page__block-h-contact">
                    По всем организационным вопросам просим Вас обращаться:
                </h3>
                <?foreach ($props['UF_ORGANIZER']['VALUE'] as $organizer):?>
                    <div class="event-page__contact-wrap">
                        <div class="event-page__contact name"><?= $organizerArr[$organizer]['UF_NAME'] ?></div>
                        <div class="event-page__contact-linc">
                            <?foreach ($organizerArr[$organizer]['UF_PHONES'] as $phone):?>
                                <a class="event-page__contact"
                                href="tel:+<?= preg_replace("/[^0-9]/", '', $phone) ?>">
                                    <?= $phone ?>
                                </a>
                            <?endforeach;?>
                        </div>
                        <div class="event-page__contact-linc">
                            <?foreach ($organizerArr[$organizer]['UF_EMAIL'] as $email):?>
                                <a class="event-page__contact"
                                href="mailto:<?= $email ?>">
                                    <?= trim($email) ?>
                                </a>
                            <?endforeach;?>
                        </div>
                    </div>
                <?endforeach;?>
            </div>
            <br>
            <br>
            <br>
        <? endif; ?>
        <? if (!empty($props['UF_SPEAKER']['VALUE'])): ?>
            <?
            $GLOBALS['spEventsFilter']['PROPERTY_UF_SPEAKER'] = $props['UF_SPEAKER']['VALUE'];
            $GLOBALS['spEventsFilter']['!ID'] = $arResult['ID'];
            ?>
            <? $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "speaker_events",
                array(
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "N",
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
                    "FILTER_NAME" => "spEventsFilter",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "IBLOCK_ID" => "3",
                    "IBLOCK_TYPE" => "content",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "MESSAGE_404" => "",
                    "NEWS_COUNT" => "6",
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
                        0 => "UF_EVENT_TYPE",
                        1 => "UF_TIME_AFT",
                        2 => "UF_TIME_BEF",
                        3 => "UF_DATE_ACTIVE",
                        4 => "UF_PROGRAM_SHORT",
                        5 => "UF_REGISTER_PAY",
                        6 => "",
                    ),
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SORT_BY1" => "ACTIVE_TO",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER1" => "ASC",
                    "SORT_ORDER2" => "ASC",
                    "STRICT_SECTION_CHECK" => "N",
                    "COMPONENT_TEMPLATE" => "speaker_events"
                ),
                false
            ); ?>
        <? endif; ?>
    </div>
</div>
<div class="container-wrap event-page__main2">
    <div class="container-item event-page">
        <? if (!empty($props['UF_THEME']['VALUE'])): ?>
            <? $GLOBALS['videoEventsFilter']['PROPERTY_UF_THEME'] = $props['UF_THEME']['VALUE'] ?>
            <? $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "video_events_page",
                array(
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "N",
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
                    "FIELD_CODE" => array("", ""),
                    "FILE_404" => "",
                    "FILTER_NAME" => "videoEventsFilter",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "IBLOCK_ID" => "6",
                    "IBLOCK_TYPE" => "content",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "MESSAGE_404" => "",
                    "NEWS_COUNT" => "4",
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
                    "PROPERTY_CODE" => array("", ""),
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "Y",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER1" => "DESC",
                    "SORT_ORDER2" => "ASC",
                    "STRICT_SECTION_CHECK" => "N"
                )
            ); ?>
        <? endif; ?>
        <? $APPLICATION->IncludeComponent("bitrix:subscribe.edit", "subscribe", array(
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
        <a class="linc-arrow" href="<?= $arResult['SECTION']['SECTION_PAGE_URL'] ?>">
            <svg width="14" height="8">
                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-arrow"></use>
            </svg>
            <span>Вернуться назад</span>
        </a>
    </div>
</div>
