<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

/**
 * $GLOBALS['EVENT_TYPES'] - инициализация в index.php раздела events или archive
 * $GLOBALS['OPTIONS'] - инициализация в header.php
 */
global $USER;
$this->setFrameMode(true);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$APPLICATION->AddViewContent('main_class', 'class="container-wrap event-page__main"');
$APPLICATION->AddViewContent('hide_header', 'style="display: none"');
$APPLICATION->AddViewContent('hide_bread', 'style="display: none"');
$APPLICATION->AddViewContent('hide_footer', 'style="display: none"');

$props = $arResult['PROPERTIES'];

$eventType = $GLOBALS['EVENT_TYPES'][$props['UF_EVENT_TYPE']['VALUE']];
$registerPay = $props['UF_REGISTER_PAY']['VALUE'] ? 'Регистрационный взнос: ' . printApart($props['UF_REGISTER_PAY']['VALUE']) . ' ₽' : 'Бесплатно';
$colleagPoints = $GLOBALS['COLLEAG_POINTS'] = $props['UF_POINTS_COLLEAG']['VALUE'] ?: $GLOBALS['OPTIONS']['UF_POINTS_COLLEAG']['VALUE'];
$colleagHMO = $props['UF_POINTS_HMO']['VALUE'] ?: $GLOBALS['OPTIONS']['UF_POINTS_HMO']['VALUE'];
$colleagHMODesc = $props['UF_POINTS_HMO']['~DESCRIPTION'] ?: $GLOBALS['OPTIONS']['UF_POINTS_HMO']['~DESCRIPTION'];
$colleagProteco = $props['UF_POINTS_PROTECO']['VALUE'] ?: $GLOBALS['OPTIONS']['UF_POINTS_PROTECO']['VALUE'];
$colleagProtecoDesc = $props['UF_POINTS_PROTECO']['~DESCRIPTION'] ?: $GLOBALS['OPTIONS']['UF_POINTS_PROTECO']['~DESCRIPTION'];
$ufTimeB = date("H:i", MakeTimeStamp($props['UF_TIME_BEF']['VALUE']));
$ufTimeA = date("H:i", MakeTimeStamp($props['UF_TIME_AFT']['VALUE']));

if ($arResult['IBLOCK_SECTION_ID'] != 3) {
    $isClosed = isClosed($props['UF_TIME_BEF']['VALUE']) || $props['UF_END']['VALUE'];
} else {
    $isClosed = isClosed($props['UF_TIME_AFT']['VALUE']) || $props['UF_END']['VALUE'];
}
$isOnline = isOnline($props['UF_TIME_BEF']['VALUE'], $props['UF_TIME_AFT']['VALUE']);

$isCheckNeeded = $showFileFormClass = '';
$dataAction = 'clickSignUpEvent';
if(!empty($props['IS_CHECK_NEEDED']['VALUE'])) {
    $isCheckNeeded = 'data-is-chek-needed="yes"';
    $showFileFormClass = 'show-add-check-popup';
    $dataAction = 'clickShowPaymentCheckPopup';
}

if ($USER->IsAuthorized()) {
    // $signUpBtnDataAttr = 'data-action="clickSignUpEvent" data-event-id="' . $arResult['ID'] . '"';
    $signUpBtnDataAttr = 'data-action="'.$dataAction.'" '.$isCheckNeeded.' data-event-id="' . $arResult['ID'] . '"';

    if ($colleagPoints) {
        $colleagBtn = '<button class="button button_ghost-double" data-action="clickShowPopup"
                            data-popup-name="collegInvite">
                            <div class="button_ghost__top">Пригласить коллегу</div>
                            <div class="button_ghost__bot">+'.$colleagPoints.' баллов</div>
                       </button>';
    }

    $userOrder = userOrderStatus($arResult['ID']);
} else {
    $signUpBtnDataAttr = 'data-action="clickShowPopup" '.$isCheckNeeded.' data-event-id="'.$arResult['ID'].'" data-popup-name="regToSignUp"';
}

if ($props['UF_SPEAKER']['VALUE']) {
    $spikerArr = CIBlockElement::GetByID($props['UF_SPEAKER']['VALUE']);
    if ($spiker = $spikerArr->GetNextElement()) {
        $spikerFields = $spiker->GetFields();
        $spikerProps = $spiker->GetProperties();
    }
}

if (isset($_GET['INVITE']) && $colleagPoints) {
    addUserBonus($_GET['INVITE'], $colleagPoints, 1);
}

if (isset($_GET['ORDER_ID']) && $userOrder['ORDER_ID'] === $_GET['ORDER_ID']):
    include_once dirname(__FILE__) . '/template_order.php';
else:?>
    <?
    if ($isClosed) {
        $btnTemplate = '<button class="button">Запись закрыта</button>';
    } elseif (!$userOrder) {
        if ($USER->IsAuthorized()) {
            $btnTemplate = '<button class="button button_green '.$showFileFormClass.'"' . $signUpBtnDataAttr . '>Записаться</button>';
        } else {
            $btnTemplate = '<button data-active-control="popup1" class="button button_green show-modal-with-check"' . $signUpBtnDataAttr . '>Записаться</button>';
        }
    } else {
        if ($userOrder['STATUS'] === 'NEED_PAY' && !$isClosed && !$isOnline && empty($props['UF_IS_ONLINE_PAY_DISABLED']['VALUE'])) {
            $btnClass = 'class="button"';
            $btnHref = 'href="?ORDER_ID=' . $userOrder['ORDER_ID'] . '"';
            $btnText = 'Оплатить';
        } elseif ($userOrder['STATUS'] === 'NEED_PAY' && !$isClosed && $isOnline) {

        } elseif ($userOrder['STATUS'] === 'NEED_PAY' && !$isClosed && !$isOnline && !empty($props['UF_IS_ONLINE_PAY_DISABLED']['VALUE'])) {

        } elseif ($userOrder['STATUS'] === 'PAYED' && !$isClosed && $isOnline) {
                $btnClass = 'class="button button_orange"';
                $btnHref = 'target="_blank" href="' . $props['UF_VIDEO_YOUTUBE']['VALUE'] . '"';
                $btnText = 'Присоединиться';
                $btnSVG = '<svg width="10" height="10">
                                <use xlink:href="' . SITE_TEMPLATE_PATH . '/assets/images/sprite.svg#icon-button-play"></use>
                           </svg>';
        } else {
            $btnClass = 'class="button"';
            $btnText = 'Вы записаны';
        }
        $btnTemplate = '<a '.$btnClass.' '.$btnHref.'>
                            '.$btnSVG.'
                            <span>'.$btnText.'</span>
                        </a>';
    }?>
    <div class="container-item event-page" id="<?= $arResult['ID'] ?>"
         itemscope itemtype="http://schema.org/Product">
        <div class="event-page__head">
            <div class="event-page__head-left">
                <div class="event-page__head-title">
                    <div class="event-page__head-name"><?= $eventType['UF_NAME'] ?></div>
                    <? if ($props['UF_DATE_ACTIVE']['VALUE']):?>
                        <div class="event-page__head-time">
                            <svg width="17" height="17">
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-date"></use>
                            </svg>
                            <span><?= FormatDate("d F Y", MakeTimeStamp($props['UF_DATE_ACTIVE']['VALUE']))?></span>
                        </div>
                    <? endif; ?>
                    <? if ($ufTimeB || $ufTimeA):
                        ?>
                        <div class="event-page__head-time">
                            <svg width="17" height="17">
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-time"></use>
                            </svg>
                            <span><?= $ufTimeB ? 'с ' . $ufTimeB : '' ?> <?= $ufTimeA ? 'до ' . $ufTimeA : '' ?></span>
                        </div>
                    <? endif; ?>
                </div>
                <h1 class="event-page__head-h"><?= $arResult['NAME'] ?></h1>
                <div class="event-page__head-pay"><?= $registerPay ?></div>
                <div class="event-page__head-button-wrap">
                    <?= $btnTemplate ?>
                    <?= $colleagBtn?>
                </div>
            </div>
            <?if ($props['UF_VIDEO_YT_PREVIEW']['VALUE']){
                $youTubeId = explode('&', explode('=', parse_url($props['UF_VIDEO_YT_PREVIEW']['VALUE'], PHP_URL_QUERY))[1])[0];

                ?>
                <div class="video-main__linc-body event-page__video">
                    <div class="video-main__linc-wrap" data-video-play='video1'>
                        <div class="video-main__linc-play">
                            <svg width="22" height="22">
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-button-play"></use>
                            </svg>
                        </div>
                        <img class="video-main__linc-img" src="<?= CFile::GetPath($props['UF_PHOTO_YT_PREVIEW']['VALUE']); ?>"
                            alt="<?= $arResult['NAME'] ?>">
                    </div>
                    <iframe data-video-frame='video1' class="video-main__video" data-video-url="<?=$props['UF_VIDEO_YT_PREVIEW']['VALUE']?>?autoplay=1" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                </div>
               <!-- <div class="popups__wrap" data-active-block="video1">
                   <div class="popups popups_video">
                       <iframe src="<?//=$props['UF_VIDEO_YT_PREVIEW']['VALUE']?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                   </div>
                   <button class="popups__close popups__close_video" data-active-control="video1">
                       <svg width="15" height="15">
                           <use xlink:href="<?//= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-cancel-button"></use>
                       </svg>
                   </button>
                   <div class="popups__close-area popups__close-area_video" data-active-control="video1"></div>
                </div> -->
            <??>
            <? } elseif ($props['UF_PHOTO_YT_PREVIEW']['VALUE']) {
                $videoPreviewImg = CFile::GetPath($props['UF_PHOTO_YT_PREVIEW']['VALUE']);
            } elseif ($youTubeId) {
                $videoPreviewImg = '//img.youtube.com/vi/'.$youTubeId.'/maxresdefault.jpg';
            } else {
                $videoPreviewImg = null;
            } ?>
            <?if ($videoPreviewImg) :?>
                <div class="video-main__linc-body event-page__video" data-active-control="video1">
                    <div class="video-main__linc-play">
                        <svg width="22" height="22">
                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-button-play"></use>
                        </svg>
                    </div>
                    <img class="video-main__linc-img" src="<?= $videoPreviewImg ?>"
                         alt="<?= $arResult['NAME'] ?>">
                </div>
            <?endif;?>
        </div>
        <div class="event-page__body">
            <div class="event-page__body-wrap">
                <? if ($spikerFields && $spikerProps): ?>
                    <div class="event-page__block">
                        <h3 class="event-page__block-h">Спикер</h3>
                        <div class="event-page__spicer">
                            <img class="event-page__spicer-image" width="150" height="220"
                                 src="<?= CFile::GetPath($spikerFields['PREVIEW_PICTURE']) ?>"
                                 alt="<?= $spikerFields['NAME'] ?>">
                            <div class="event-page__spicer-text-wrap">
                                <h4 class="event-page__spicer-h">
                                    <?= $spikerFields['NAME'] ?> <?= $spikerProps['UF_CITY']['VALUE'] ? '(' . $spikerProps['UF_CITY']['VALUE'] . ')' : '' ?>
                                </h4>
                                <p class="event-page__spicer-text"><?= $spikerFields['~PREVIEW_TEXT'] ?></p>
                            </div>
                        </div>
                    </div>
                <? endif; ?>
                <div class="event-page__block">
                    <h3 class="event-page__block-h">Участие в мероприятии:</h3>
                    <? if ($colleagHMO): ?>
                        <div class="event-page__bali wat" <? if ($colleagHMODesc): ?>data-tooltip<? endif;
                        ?>>
                            <?= $colleagHMO ?> баллов НМО
                            <? if ($colleagHMODesc): ?>
                                <div class="tooltip"><?= $colleagHMODesc ?></div>
                            <? endif; ?>
                        </div>
                    <? endif; ?>
                    <? if ($colleagProteco): ?>
                        <div class="event-page__bali wat" <? if ($colleagProtecoDesc): ?>data-tooltip<? endif;
                        ?>>
                            <?= $colleagProteco ?> баллов Протеко
                            <? if ($colleagProtecoDesc): ?>
                                <div class="tooltip"><?= $colleagProtecoDesc ?></div>
                            <? endif; ?>
                        </div>
                    <? endif; ?>
                    <div class="event-page__block-pay"><?= $registerPay ?></div>
                    <div class="event-page__head-button-wrap">
                        <?= $btnTemplate ?>
                        <?= $colleagBtn?>
                    </div>
                </div>
                <? if ($props['UF_ORGANIZER']['VALUE']):
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
                <? endif; ?>
            </div>
            <div class="event-page__body-wrap">
                <? if (!empty($props['UF_PROGRAM']['~VALUE']) || !empty($props['UF_PROGRAM_SHORT']['~VALUE'])): ?>
                    <?$programArr = $props['UF_PROGRAM']['~VALUE'] ? : $props['UF_PROGRAM_SHORT']['~VALUE']?>
                    <div class="event-page__block">
                        <h3 class="event-page__block-h">Основные моменты</h3>
                        <ul class="event-page__block-list">
                            <? foreach ($programArr as $program): ?>
                                <li class="event-page__block-list-item">
                                    <?= $program['TEXT'] ?>
                                </li>
                            <? endforeach; ?>
                        </ul>
                    </div>
                <? endif; ?>
                <div class="event-page__block">
                    <div class="event-page__info-wrap">
                        <?
                        if ($props['UF_DURATION']['VALUE']) {
                            $durationTime = $props['UF_DURATION']['VALUE'] . ' ' . $props['UF_DURATION']['~DESCRIPTION'];
                        } else if ($props['UF_TIME_BEF']['VALUE'] && $props['UF_TIME_AFT']['VALUE']) {
                            $durationTime = timeDuration($props['UF_TIME_BEF']['VALUE'], $props['UF_TIME_AFT']['VALUE']);
                        }
                        ?>
                        <? if ($durationTime): ?>
                            <div class="event-page__info">
                                <div class="event-page__info-head">Продолжительность</div>
                                <div class="event-page__info-text"><?= $durationTime ?></div>
                            </div>
                        <? endif; ?>
                        <? if ($props['UF_LOCATION']['~VALUE']): ?>
                            <div class="event-page__info">
                                <div class="event-page__info-head">Место проведения</div>
                                <div class="event-page__info-text"><?= $props['UF_LOCATION']['~VALUE'] ?></div>
                            </div>
                        <? endif; ?>
                    </div>
                    <script data-skip-moving="true" src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=c5fc5199-ffeb-4030-a7b6-3369088c5bd2" type="text/javascript"></script>
                    <?if ($props['UF_LOCATION_MAP']['VALUE'] && $props['UF_LOCATION']['~VALUE'] && strpos($props['UF_LOCATION']['~VALUE'], 'On-line') === false):
                        $coords = explode(',', $props['UF_LOCATION_MAP']['VALUE']);?>
                        <div class="event-page__map" id="event-page-map"
                            data-map-x="<?=$coords[0]?>" data-map-y="<?=$coords[1]?>"></div>
                    <?endif;?>
                </div>
            </div>
        </div>
        <? global $USER;
        if ($USER->IsAdmin()) {
            echo '<pre>';
            $section = $arResult['SECTION']['PATH'][0]['CODE'];
            $dateNow = new datetime();
            $date = strtotime($dateNow->format('Y-m-d H:i:s'));
            $dateEvent = strtotime($arResult['PROPERTIES']['UF_TIME_AFT']['VALUE']);
            $archive = ($date > $dateEvent);
            if ($archive) {
                $link = '/archive/';
            } else {
                $link = '/events';
            }
        };?>
        <a class="linc-arrow" href="<?= $arResult['SECTION']['SECTION_PAGE_URL'] ?>">
            <svg width="14" height="8">
                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-arrow"></use>
            </svg>
            <span>Вернуться назад</span>
        </a>
    </div>
<? endif; ?>
