<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
?>
<div class="lk__content">
    <? if (!empty($arResult["ITEMS"])): ?>
        <ul class="lk__evnt-list" data-entity="container-<?= $arResult['NAV_RESULT']->NavNum ?>">
            <? foreach ($arResult["ITEMS"] as $arItem): ?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                $props = $arItem['PROPERTIES'];
                $eventType = $GLOBALS['EVENT_TYPES'][$props['UF_EVENT_TYPE']['VALUE']];

                /*if(!empty($props['UF_IN_COURSE']['VALUE'])){
                    $arFilter = Array("IBLOCK_ID"=>9, "ID"=>$props['UF_IN_COURSE']['VALUE'], "ACTIVE"=>"Y");
                    $courseObArr = CIBlockElement::GetList(Array(), $arFilter, false, Array(), Array());
                    while ($courseArr = $courseObArr->GetNext()) {
                        echo '<pre>';
                        print_r($courseArr);
                        echo '</pre>';
                    }
                }*/
                ?>
                <li class="event-card-l" data-entity="item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                    <div class="event-card-l__left <?=$eventType['UF_LINK']?>">
                        <svg class="event-card-l__left-icon" width="45" height="45">
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#<?=$eventType['UF_DESCRIPTION']?>"></use>
                        </svg>
                        <span class="event-card-l__left-name"><?=$eventType['UF_NAME']?></span>
                    </div>
                    <div class="event-card-l__body">
                        <div class="event-card-l__date-wrap">
                            <div class="event-card-l__date-name"><?=$eventType['UF_NAME']?></div>
                            <?if ($props['UF_DATE_ACTIVE']['VALUE']):?>
                                <div class="event-card-l__date">
                                    <svg width="17" height="17">
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-date"></use>
                                    </svg><span><?=$props['UF_DATE_ACTIVE']['VALUE']?></span>
                                </div>
                            <?endif;?>
                            <?if ($props['UF_TIME_BEF']['VALUE'] || $props['UF_TIME_AFT']['VALUE']):
                                $ufTimeB = date("H:i", MakeTimeStamp($props['UF_TIME_BEF']['VALUE']));
                                $ufTimeA = date("H:i", MakeTimeStamp($props['UF_TIME_AFT']['VALUE']));
                                ?>
                                <div class="event-card-l__date">
                                    <svg width="17" height="17">
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-time"></use>
                                    </svg><span><?=$ufTimeB ? 'с '.$ufTimeB : ''?> <?=$ufTimeA ? 'до '.$ufTimeA : ''?></span>
                                </div>
                            <?endif;?>
                        </div>
                        <h3 class="event-card-l__body-h">
                            <?=$arItem['NAME']?>
                        </h3>
                        <?/*?>
                        <div class="event-card-l__body-text">
                            <p>Семинар из базового курса по стоматологии</p>
                        </div>
                        <?*/?>
                    </div>
                    <div class="event-card-l__button-wrap-bot">
                        <?if(isOnline($props['UF_TIME_BEF']['VALUE'], $props['UF_TIME_AFT']['VALUE'])):?>
                            <a class="button button_orange" href="<?=$arItem['DETAIL_PAGE_URL']?>">
                                <svg width="10" height="10">
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-button-play"></use>
                                </svg>
                                <span>Присоединиться</span>
                            </a>
                            <div class="event-card-l__button-now"><?=$eventType['UF_NAME']?> идет</div>
                        <?else:?>
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="button">Подробнее</a>
                        <?endif;?>
                    </div>
                </li>
                <?unset($eventType)?>
                <?unset($onlineTimeB)?>
            <? endforeach; ?>
        </ul>
        <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
            <?= $arResult["NAV_STRING"] ?>
        <? endif; ?>
    <?else:?>
        <p class="lk__none-text">Вы пока не зарегистрированны на участие ни в одном мероприятии. </p>
    <? endif; ?>
</div>

