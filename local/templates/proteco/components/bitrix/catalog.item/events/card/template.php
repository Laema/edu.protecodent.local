<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */

/**
 * $GLOBALS['EVENT_TYPES'] - инициализация в index.php раздела events или archive
 * $GLOBALS['USER_ORDERS'] - инициализация в header.php
 */

$props = $item['PROPERTIES'];
$eventType = $GLOBALS['EVENT_TYPES'][$props['UF_EVENT_TYPE']['VALUE']];

if ($arResult['ITEM']['IBLOCK_SECTION_ID'] != 3) {
    $isClosed = isClosed($props['UF_TIME_BEF']['VALUE']) || $arResult['ITEM']['PROPERTIES']['UF_END']['VALUE'];
} else {
    $isClosed = isClosed($props['UF_TIME_AFT']['VALUE']) || $arResult['ITEM']['PROPERTIES']['UF_END']['VALUE'];
}

$isCheckNeeded = $showFileFormClass = '';
$dataAction = 'clickSignUpEvent';
if(!empty($props['IS_CHECK_NEEDED']['VALUE'])) {
    $isCheckNeeded = 'data-is-chek-needed="yes"';
    $showFileFormClass = 'show-add-check-popup';
    $dataAction = 'clickShowPaymentCheckPopup';
}

global $USER;
if ($USER->IsAuthorized()) {
    if ($isClosed) {
        $btnTemplate = '<button class="button">Запись закрыта</button>';
    }elseif (in_array($item['ID'], $GLOBALS['USER_ORDERS']['EVENTS_ID'])) {
        $btnTemplate = '<a class="button" href="' . $item['DETAIL_PAGE_URL'] . '">Вы записаны</a>';
    } else {
        // $btnTemplate = '<button class="button" data-action="clickSignUpEvent" data-event-id="' . $item['ID'] . '">Записаться</button>';
        $btnTemplate = '<button class="button '.$showFileFormClass.'" data-action="'.$dataAction.'" '.$isCheckNeeded.' data-event-id="' . $item['ID'] . '">Записаться</button>';
    }
} else {
    if ($isClosed) {
        $btnTemplate = '<button class="button">Запись закрыта</button>';
    } else {
        // $btnTemplate = '<button class="button" data-active-control="popup1" data-action="clickShowPopup" data-event-id="' . $item['ID'] . '" data-popup-name="regToSignUp">Записаться</button>';
        $btnTemplate = '<button class="button show-modal-with-check" data-active-control="popup1" '.$isCheckNeeded.' data-action="clickShowPopup" data-event-id="' . $item['ID'] . '" data-popup-name="regToSignUp">Записаться</button>';

    }
}
?>
    <div class="event-card__head <?= $eventType['UF_LINK'] ?>">
        <svg class="event-card__head-icon" width="45" height="45">
            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#<?= $eventType['UF_DESCRIPTION'] ?>"></use>
        </svg>
        <span class="event-card__head-text"><?= $eventType['UF_NAME'] ?></span>
        <? if (!empty($props['UF_IN_COURSE']['VALUE'])): ?>
            <div class="event-card__head-label"><span>Доступно в курсе</span></div>
        <? endif; ?>
    </div>
    <div class="event-card__body">
        <div class="event-card__time-wrap">
            <? if ($props['UF_DATE_ACTIVE']['VALUE']): ?>
                <div class="event-card__time">
                    <svg width="17" height="17">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-date"></use>
                    </svg>
                    <span><?= FormatDate("d F Y", MakeTimeStamp($props['UF_DATE_ACTIVE']['VALUE'])) ?></span>
                </div>
            <? endif; ?>
            <? if ($props['UF_TIME_BEF']['VALUE'] || $props['UF_TIME_AFT']['VALUE']):
                $ufTimeB = date("H:i", MakeTimeStamp($props['UF_TIME_BEF']['VALUE']));
                $ufTimeA = date("H:i", MakeTimeStamp($props['UF_TIME_AFT']['VALUE']));
                ?>
                <div class="event-card__time">
                    <svg width="17" height="17">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-time"></use>
                    </svg>
                    <span><?= $ufTimeB ? 'с ' . $ufTimeB : '' ?> <?= $ufTimeA ? 'до ' . $ufTimeA : '' ?></span>
                </div>
            <? endif; ?>
        </div>
        <h4 class="event-card__heading"><?= $item['NAME'] ?></h4>
        <? if ($props['UF_SPEAKER']['VALUE']): ?>
            <?
            $spikerArr = CIBlockElement::GetByID($props['UF_SPEAKER']['VALUE']);
            if ($spiker = $spikerArr->GetNextElement()) :
                $spikerFields = $spiker->GetFields();
                $spikerProps = $spiker->GetProperties();
                ?>
                <img class="event-card__person-img" width="80"
                     src="<?= CFile::GetPath($spikerFields['PREVIEW_PICTURE']) ?>" alt="<?= $spikerFields['NAME'] ?>">
                <div class="event-card__person-text-wrap">
                    <div class="event-card__person-name"><?= $spikerFields['NAME'] ?> <?= $spikerProps['UF_CITY']['VALUE'] ? '(' . $spikerProps['UF_CITY']['VALUE'] . ')' : '' ?></div>
                    <div class="event-card__person-text"><?= $spikerFields['~PREVIEW_TEXT'] ?></div>
                </div>
            <? endif; ?>
        <? endif; ?>
        <div class="event-card__bot">
            <div class="event-card__bot-pey"><?= $props['UF_REGISTER_PAY']['VALUE'] ? 'Регистрационный взнос: ' . printApart($props['UF_REGISTER_PAY']['VALUE']) . ' ₽' : 'Бесплатно' ?></div>
            <?= $btnTemplate ?>
        </div>
    </div>
<? if (!empty($props['UF_PROGRAM_SHORT']['~VALUE'])): ?>
    <a class="event-card__program" href="<?= $item['DETAIL_PAGE_URL'] ?>">
        <div class="event-card__program-head">Программа курса</div>
        <ol class="event-card__program-list">
            <? foreach ($props['UF_PROGRAM_SHORT']['~VALUE'] as $program): ?>
                <li class="event-card__program-item"><?= $program['TEXT'] ?></li>
            <? endforeach; ?>
        </ol>
    </a>
<? endif; ?>
