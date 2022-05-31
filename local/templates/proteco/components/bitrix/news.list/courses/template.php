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
<section class="container-wrap course-list__wrap">
    <div class="container-item course-list">
        <h1 class="h1 course-list__h"><? $APPLICATION->showTitle(false) ?></h1>
        <ul class="course-list__list" data-entity="container-<?= $arResult['NAV_RESULT']->NavNum ?>">
            <? foreach ($arResult["ITEMS"] as $arItem): ?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                $props = $arItem['PROPERTIES'];

                $courseType = $GLOBALS['COURSES_TYPES'][$props['UF_COURSE_TYPE']['VALUE']];
                ?>
                <li class="course-list__item<?if ($props['UF_COURSE_TYPE']['VALUE'] === 'vHAAYkmn'):?> course-list__item_input<?endif;?>"
                    id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                    <div class="course-list__head" <?if($courseType['UF_FULL_DESCRIPTION']):?>style="background: <?=$courseType['UF_FULL_DESCRIPTION']?>"<?endif;?>>
                        <?= $arItem['NAME'] ?>
                    </div>
                    <?if ($props['UF_COURSE_TYPE']['VALUE'] === 'vHAAYkmn'):?>
                        <form class="course-list__body">
                            <p class="course-list__text">Психоанализ транслирует параллельный закон, это же положение обосновывал Ж.Польти в книге "Тридцать шесть драматических ситуаций".</p>
                            <div class="course-list__input-wrap">
                                <input class="input" type="text" name="" placeholder="Как к вам обращаться?">
                                <input class="input" type="tel" name="" placeholder="Ваш телефон">
                            </div>
                            <p class="course-list__person-info">Нажимая на кнопку, я подтверждаю, что согласен на обработку моих персональных данных, а также с <a href="#">Пользовательским соглашением</a></p>
                            <button class="button" type="submit">Записаться на консультацию</button>
                        </form>
                    <?else:?>
                        <?
                        $arFilter = Array("IBLOCK_ID"=>3, "ID"=>$props['UF_EVENTS']['VALUE'], "ACTIVE"=>"Y");
                        $eventObArr = CIBlockElement::GetList(Array("PROPERTY_UF_DATE_ACTIVE" => "ASC"), $arFilter, false, Array(), Array());
                        while($eventOb = $eventObArr->GetNextElement())
                        {
                            $eventFields = $eventOb->GetFields();
                            $eventProps = $eventOb->GetProperties();
                            $eventDates[] = $eventProps['UF_DATE_ACTIVE']['VALUE'];
                            $eventType = $GLOBALS['EVENT_TYPES'][$eventProps['UF_EVENT_TYPE']['VALUE']];
                            $eventTypeCount[$eventType['UF_XML_ID']][] = $eventType['UF_NAME'];
                            $speakerCount[$eventProps['UF_SPEAKER']['VALUE']][] = $eventProps['UF_SPEAKER']['VALUE'];
                        }
                        ?>
                        <div class="course-list__body">
                            <div class="course-list__date-wrap">
                                <?if (!empty($eventDates)):?>
                                    <?$dCount = count($eventDates);?>
                                    <div class="course-list__date">
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
                            </div>
                            <p class="course-list__text"><?= $arItem["~PREVIEW_TEXT"] ?></p>
                            <div class="course-list__icon-wrap">
                                <?foreach ($eventTypeCount as $key => $countItem):?>
                                    <div class="course-list__icon">
                                        <svg width="40" height="40">
                                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#<?=$GLOBALS['EVENT_TYPES'][$key]['UF_DESCRIPTION']?>"></use>
                                        </svg>
                                        <span><?=declOfNum(count($countItem), $GLOBALS['EVENT_TYPES'][$key]['UF_ENDINGS']); ?></span>
                                    </div>
                                <?endforeach;?>
                                <?if (!empty($speakerCount)):?>
                                    <div class="course-list__icon">
                                        <svg width="40" height="40">
                                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-webinar"></use>
                                        </svg>
                                        <span><?=declOfNum(count($speakerCount), ['спикер', 'спикера', 'спикеров']); ?></span>
                                    </div>
                                <?endif;?>
                            </div>
                            <div class="course-list__button-wrap">
                                <?if ($props['UF_PRICE']['VALUE']):?>
                                    <div class="course-list__prise">Стоимость курса: <br><?=printApart($props['UF_PRICE']['VALUE'])?> ₽</div>
                                <?endif;?>
                                <a class="button" href="<?=$arItem['DETAIL_PAGE_URL']?>">Подробнее</a>
                            </div>
                        </div>
                        <?
                        unset($eventTypeCount);
                        unset($speakerCount);
                        unset($eventDates);
                        ?>
                    <?endif;?>
                </li>
            <? endforeach; ?>
        </ul>
        <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
            <?= $arResult["NAV_STRING"] ?>
        <? endif; ?>
    </div>
</section>