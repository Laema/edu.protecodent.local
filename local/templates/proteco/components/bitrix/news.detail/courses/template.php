<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$props = $arResult['PROPERTIES'];

$colleagPoints = $GLOBALS['COLLEAG_POINTS'] = $props['UF_POINTS_COLLEAG']['VALUE'] ? : $GLOBALS['OPTIONS']['UF_POINTS_COLLEAG']['VALUE'];
$colleagHMO = $props['UF_POINTS_HMO']['VALUE'] ? : $GLOBALS['OPTIONS']['UF_POINTS_HMO']['VALUE'];
$colleagHMODesc = $props['UF_POINTS_HMO']['~DESCRIPTION'] ? : $GLOBALS['OPTIONS']['UF_POINTS_HMO']['~DESCRIPTION'];
$colleagProteco = $props['UF_POINTS_PROTECO']['VALUE'] ? : $GLOBALS['OPTIONS']['UF_POINTS_PROTECO']['VALUE'];
$colleagProtecoDesc = $props['UF_POINTS_PROTECO']['~DESCRIPTION'] ? : $GLOBALS['OPTIONS']['UF_POINTS_PROTECO']['~DESCRIPTION'];

$arFilter = Array("IBLOCK_ID"=>3, "ID"=>$props['UF_EVENTS']['VALUE'], "ACTIVE"=>"Y");
$eventObArr = CIBlockElement::GetList(Array("PROPERTY_UF_DATE_ACTIVE" => "ASC"), $arFilter, false, Array(), Array());

while($eventOb = $eventObArr->GetNextElement())
{
    $eventFields = $eventOb->GetFields();
    $needlId[] = $eventFields['ID'];
    $eventAddIDs[] = $eventFields['ID'];
    $eventArr[$eventFields['ID']] = $eventFields;
    $eventArr[$eventFields['ID']]['PROPERTIES'] = $eventProps = $eventOb->GetProperties();
    $eventDates[] = $eventProps['UF_DATE_ACTIVE']['VALUE'];
    $eventType = $GLOBALS['EVENT_TYPES'][$eventProps['UF_EVENT_TYPE']['VALUE']];
    $eventTypeCount[$eventType['UF_XML_ID']][] = $eventType['UF_NAME'];
    $speakerCount[$eventProps['UF_SPEAKER']['VALUE']][] = $eventProps['UF_SPEAKER']['VALUE'];
}
foreach ($needlId as $key => $item) {
    if (in_array($item,$GLOBALS['USER_ORDERS']['EVENTS_ID'])) {
        $courseRecord = true;
    } else {
        $courseRecord = false;
        break;
    }
}

if ($USER->IsAuthorized()) {
    $signUpBtnDataAttr = 'data-action="clickSignUpCourse" data-events-id="' . implode(',', $eventAddIDs) . '" data-course-id="'.$arResult['ID'].'"';
    if ($colleagPoints) {
        $colleagBtn = '<button class="button button_ghost-double" data-action="clickShowPopup" 
                            data-popup-name="collegInvite">
                            <div class="button_ghost__top">Пригласить коллегу</div>
                            <div class="button_ghost__bot">+'.$colleagPoints.' баллов</div>
                       </button>';
    }
} else {
    $signUpBtnDataAttr = 'data-action="clickShowPopup" data-popup-name="regToSignUp"';
}
if (isset($_GET['INVITE']) && $colleagPoints) {
    addUserBonus($_GET['INVITE'], $colleagPoints, 1);
}

?>
<section class="container-wrap course-pages__wrap">
    <div class="container-item course-pages">
        <h1 class="h1 course-pages__h"><? $APPLICATION->showTitle(false) ?></h1>
        <div class="course-pages__info">
            <?if (!empty($eventDates)):?>
                <?$dCount = count($eventDates);?>
                <div class="course-pages__info-date">
                    <svg width="17" height="17">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-date"></use>
                    </svg>
                    <?if ($dCount === 1):?>
                        <span><?=$eventDates[0]?></span>
                    <?else:?>
                        <span>с <?=$eventDates[0]?> по <?=$eventDates[$dCount-1]?></span>
                    <?endif;?>
                </div>
            <?endif;?>
            <?if ($colleagHMO):?>
                <div class="course-pages__info-balls wat" <?if ($colleagHMODesc):?>data-tooltip<?endif;?>>
                    <?=$colleagHMO?> баллов НМО
                    <?if ($colleagHMODesc):?>
                        <div class="tooltip"><?=$colleagHMODesc?></div>
                    <?endif;?>
                </div>
            <?endif;?>
            <?if ($colleagProteco):?>
                <div class="course-pages__info-balls wat" <?if ($colleagProtecoDesc):?>data-tooltip<?endif;?>>
                    <?=$colleagProteco?> баллов Протеко
                    <?if ($colleagProtecoDesc):?>
                        <div class="tooltip"><?=$colleagProtecoDesc?></div>
                    <?endif;?>
                </div>
            <?endif;?>
            <?if ($props['UF_PRICE']['VALUE']):?>
                <div class="course-pages__info-pay">
                    Стоимость курса: <?=printApart($props['UF_PRICE']['VALUE'])?> ₽
                </div>
            <?endif;?>
            <? if ($courseRecord) :?>
                <button class="button course-pages__info-button">Вы записаны</button>
            <? else:?>
                <button class="button course-pages__info-button" <?=$signUpBtnDataAttr?>>Записаться</button>
            <? endif;?>
        </div>
        <h2 class="course-pages__list-h">В курс входят следующие мероприятия:</h2>
        <div class="course-pages__list">
            <?foreach ($eventArr as $key => $event):?>
                <?
                $eventProps = $event['PROPERTIES'];
                $eventType = $GLOBALS['EVENT_TYPES'][$eventProps['UF_EVENT_TYPE']['VALUE']];
                ?>
                <div class="course-linc" data-tab-control="courseLinc<?=$key?>">
                    <div class="course-linc__text"><?=$event['NAME']?>
                        <div class="button course-linc__button">Подробнее</div>
                    </div>
                    <div class="course-linc__number"><span></span></div>
                </div>
                <div class="course-info__wrap" data-tab-block="courseLinc<?=$key?>">
                    <div class="course-info" data-tab-height>
                        <div class="course-info__text-wrap">
                            <h3 class="course-info__h"><?=$eventType['UF_NAME']?></h3>
                            <p class="course-info__text"><?=$eventProps['UF_DATE_ACTIVE']['VALUE']?></p>
                        </div>
                        <?
                        if ($eventProps['UF_DURATION']['VALUE']){
                            $durationTime = $eventProps['UF_DURATION']['VALUE'].' '.$eventProps['UF_DURATION']['~DESCRIPTION'];
                        } else if ($eventProps['UF_TIME_BEF']['VALUE'] && $eventProps['UF_TIME_AFT']['VALUE']) {
                            $durationTime = timeDuration($eventProps['UF_TIME_BEF']['VALUE'], $eventProps['UF_TIME_AFT']['VALUE']);
                        }
                        if ($durationTime):?>
                            <div class="course-info__text-wrap course-info_05">
                                <h4 class="course-info__text-h">Продолжительность</h4>
                                <p class="course-info__text"><?=$durationTime?></p>
                            </div>
                        <?endif;?>
                        <?if ($eventProps['UF_LOCATION']['~VALUE']):?>
                            <div class="course-info__text-wrap course-info_05">
                                <h4 class="course-info__text-h">Место проведения</h4>
                                <p class="course-info__text"><?=$eventProps['UF_LOCATION']['~VALUE']?></p>
                            </div>
                        <?endif;?>
                        <?if ($eventProps['UF_PROGRAM']['~VALUE']):?>
                            <div class="course-info__text-wrap">
                                <h4 class="course-info__text-h">Программа</h4>
                                <?foreach ($eventProps['UF_PROGRAM']['~VALUE'] as $program):?>
                                    <p class="course-info__text"><?=$program['TEXT']?></p>
                                <?endforeach;?>
                            </div>
                        <?endif;?>
                        <?if ($eventProps['UF_SPEAKER']['VALUE']):?>
                            <?
                            $spikerArr = CIBlockElement::GetByID($eventProps['UF_SPEAKER']['VALUE']);
                            if ($spiker = $spikerArr->GetNextElement()) :
                                $spikerFields = $spiker->GetFields();
                                $spikerProps = $spiker->GetProperties();
                                ?>
                                <div class="course-info__spiker">
                                    <h4 class="course-info__spiker-h">Спикер</h4>
                                    <div class="course-info__spiker-wrap">
                                        <img class="course-info__spiker-image" src="<?=CFile::GetPath($spikerFields['PREVIEW_PICTURE'])?>" alt="<?=$spikerFields['NAME']?>">
                                        <div class="course-info__spiker-text">
                                            <div class="course-info__spiker-name">
                                                <?=$spikerFields['NAME']?> <?=$spikerProps['UF_CITY']['VALUE'] ? '('.$spikerProps['UF_CITY']['VALUE'].')': ''?>
                                            </div>
                                            <div class="course-info__spiker-text">
                                                <p><?=$spikerFields['~PREVIEW_TEXT']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?endif;?>
                        <?endif;?>
                    </div>
                </div>
            <?endforeach;?>
            <div class="event-page__block course-pages__ball">
                <h3 class="event-page__block-h">За курс начисляется:</h3>
                <?if ($colleagHMO):?>
                    <div class="event-page__bali wat" <?if ($colleagHMODesc):?>data-tooltip<?endif;?>>
                        <?=$colleagHMO?> баллов НМО
                        <?if ($colleagHMODesc):?>
                            <div class="tooltip"><?=$colleagHMODesc?></div>
                        <?endif;?>
                    </div>
                <?endif;?>
                <?if ($colleagProteco):?>
                    <div class="event-page__bali wat" <?if ($colleagProtecoDesc):?>data-tooltip<?endif;?>>
                        <?=$colleagProteco?> баллов Протеко
                        <?if ($colleagProtecoDesc):?>
                            <div class="tooltip"><?=$colleagProtecoDesc?></div>
                        <?endif;?>
                    </div>
                <?endif;?>
                <div class="event-page__block-pay">Стоимость курса: <?=printApart($props['UF_PRICE']['VALUE'])?> ₽</div>
                <div class="event-page__head-button-wrap">
                    <? if ($courseRecord) :?>
                    <button  class="button">Вы записаны</button>
                    <? else :?>
                    <button class="button" <?=$signUpBtnDataAttr?>>Записаться</button>
                    <? endif;?>
                    <?=$colleagBtn?>
                </div>
            </div>
        </div>
    </div>
</section>