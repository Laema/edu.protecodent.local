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

$preFilter = $GLOBALS[$arParams['PREFILTER_NAME']];
if ($arParams['SECTION_ID'] !== 0) {
    $preFilter['SECTION_ID'] = $arParams['SECTION_ID'];
}
$preFilter['IBLOCK_ID'] = $arParams['IBLOCK_ID'];
$preFilter['IBLOCK_TYPE'] = $arParams['IBLOCK_TYPE'];

?>
<button class="button events__filter-button-active" data-active-control="filter1">
    <svg width="24" height="16">
        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-filter"></use>
    </svg>
    <span>Фильтры</span>
</button>
<form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>" method="get"
      class="events__filter" data-mission="filterForm" data-active-block="filter1">
    <? foreach ($arResult["HIDDEN"] as $arItem): ?>
        <input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>" id="<? echo $arItem["CONTROL_ID"] ?>"
               value="<? echo $arItem["HTML_VALUE"] ?>"/>
    <? endforeach; ?>
    <div class="events__filter-close close-button" data-active-control="filter1">
        <svg width="20" height="20">
            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-cancel-button"></use>
        </svg>
    </div>
    <div class="events__filter-h">
        <svg width="24" height="16">
            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-filter"></use>
        </svg>
        <h4>Фильтры</h4>
    </div>
    <? //not prices
    foreach ($arResult["ITEMS"] as $key => $arItem) {
        if (
            empty($arItem["VALUES"])
            || isset($arItem["PRICE"])
        )
            continue;

        if (
            $arItem["DISPLAY_TYPE"] == "A"
            && (
                $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
            )
        )
            continue;
        ?>
        <label class="event-page__filter-item">
            <span class="bx-filter-container-modef"></span>
            <?
            $arCur = current($arItem["VALUES"]);
            switch ($arItem["DISPLAY_TYPE"]) {
            case "P"://DROPDOWN
            $checkedItemExist = false;
            ?>
                <select class="event-select" data-action="changeFilter" name="<?= $arCur["CONTROL_NAME_ALT"] ?>"
                        data-fused="<?=$preFilter['PROPERTY_'.$arItem['CODE']] ? 'true' : 'false'?>"
                >
                    <option class="event-select__first" value="all">
                        <?= $arItem['FILTER_HINT'] ? : GetMessage("CT_BCSF_FILTER_ALL") ?>
                    </option>
                    <? foreach ($arItem["VALUES"] as $val => $ar):?>
                        <option
                                data-fc-ufn="fcufn_<?=$arItem['CODE']?>"
                                data-fc-ufv="<?=$val?>"
                                id="<?= $ar["CONTROL_ID"] ?>"
                                value="<? echo $ar["HTML_VALUE_ALT"] ?>"
                            <? echo $ar["CHECKED"] ? 'selected="selected"' : '' ?>
                        >
                            <?= $ar["VALUE"] ?>
                        </option>
                    <?endforeach ?>
                </select>
            <?
            break;
            case "U"://CALENDAR
            ?>
            <input class="events__data-range" type="text" data-action="changeDateInput"
                   data-dfilter='<?=json_encode($preFilter)?>' id="date-range">
                <div style="display: none">
                    <?$APPLICATION->IncludeComponent(
                        'bitrix:main.calendar',
                        'events',
                        array(
                            'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
                            'SHOW_INPUT' => 'Y',
                            'INPUT_ADDITIONAL_ATTR' => 'data-mission="dateMIN" data-action="changeFilter" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]).'"',
                            'INPUT_NAME' => $arItem["VALUES"]["MIN"]["CONTROL_NAME"],
                            'INPUT_VALUE' => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                            'SHOW_TIME' => 'N',
                            'HIDE_TIMEBAR' => 'Y',
                        ),
                        null,
                        array('HIDE_ICONS' => 'Y')
                    );?>
                    <? $APPLICATION->IncludeComponent(
                        'bitrix:main.calendar',
                        'events',
                        array(
                            'FORM_NAME' => $arResult["FILTER_NAME"] . "_form",
                            'SHOW_INPUT' => 'Y',
                            'INPUT_ADDITIONAL_ATTR' => 'data-mission="dateMAX" data-action="changeFilter" placeholder="' . FormatDate("SHORT", $arItem["VALUES"]["MAX"]["VALUE"]) . '"',
                            'INPUT_NAME' => $arItem["VALUES"]["MAX"]["CONTROL_NAME"],
                            'INPUT_VALUE' => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                            'SHOW_TIME' => 'N',
                            'HIDE_TIMEBAR' => 'Y',
                        ),
                        null,
                        array('HIDE_ICONS' => 'Y')
                    ); ?>
                </div>
            <?
            break;
            default://CHECKBOXES
            ?>
                <div class="col-xs-12">
                    <? foreach ($arItem["VALUES"] as $val => $ar):?>
                        <div class="checkbox">
                            <label data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                   class="bx-filter-param-label <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                   for="<? echo $ar["CONTROL_ID"] ?>">
                                                        <span class="bx-filter-input-checkbox">
                                                            <input
                                                                    type="checkbox"
                                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                onclick="smartFilter.click(this)"
                                                            />
                                                            <span class="bx-filter-param-text"
                                                                  title="<?= $ar["VALUE"]; ?>"><?= $ar["VALUE"]; ?><?
                                                                if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                                                    ?>&nbsp;(<span
                                                                        data-role="count_<?= $ar["CONTROL_ID"] ?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
                                                                endif; ?></span>
                                                        </span>
                            </label>
                        </div>
                    <?endforeach; ?>
                </div>
            <?
            }
            ?>
        </label>
        <?
    }
    ?>
    <button type="submit" style="display: none"></button>
    <div class="button events__filter-button" data-active-control="filter1">Применить фильтрацию</div>
</form>
<script type="text/javascript">
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>