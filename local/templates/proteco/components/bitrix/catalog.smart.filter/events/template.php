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
<form name="<? echo $arParams["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>" method="get"

      class="events__filter" data-mission="filterForm" data-active-block="filter1">
      <input type="hidden" name="IS_AJAX" value="1" data-action="changeFilter">
    <? foreach ($arResult["HIDDEN"] as $arItem): ?>
        <?if ($arItem["CONTROL_NAME"] === 'filterSPEAKER') continue;?>
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
    <div class="events__filter-switch">
        <label class="switch">
            <?if(!CSite::InDir('/archive/')):?>
                <input class="switch__input" type="checkbox" name="">
                <div class="switch__item"></div>
                <span class="switch__text">Скрыть просмотренные</span>
            <?endif;?>
        </label>
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
        if (isset($_GET['filterSPEAKER']) && $arItem['CODE'] === 'UF_EVENT_TYPE') continue;
        ?>
        <label class="event-page__filter-item">
            <span class="bx-filter-container-modef"></span>
            <?
            $arCur = current($arItem["VALUES"]);
            switch ($arItem["DISPLAY_TYPE"]) {
            case "A"://NUMBERS_WITH_SLIDER
                ?>
                <div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
                    <i class="bx-ft-sub"><?= GetMessage("CT_BCSF_FILTER_FROM") ?></i>
                    <div class="bx-filter-input-container">
                        <input
                                class="min-price"
                                type="text"
                                name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                size="5"
                                onkeyup="smartFilter.keyup(this)"
                        />
                    </div>
                </div>
                <div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
                    <i class="bx-ft-sub"><?= GetMessage("CT_BCSF_FILTER_TO") ?></i>
                    <div class="bx-filter-input-container">
                        <input
                                class="max-price"
                                type="text"
                                name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                size="5"
                                onkeyup="smartFilter.keyup(this)"
                        />
                    </div>
                </div>

                <div class="col-xs-10 col-xs-offset-1 bx-ui-slider-track-container">
                    <div class="bx-ui-slider-track" id="drag_track_<?= $key ?>">
                        <?
                        $precision = $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0;
                        $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 4;
                        $value1 = number_format($arItem["VALUES"]["MIN"]["VALUE"], $precision, ".", "");
                        $value2 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step, $precision, ".", "");
                        $value3 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 2, $precision, ".", "");
                        $value4 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 3, $precision, ".", "");
                        $value5 = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
                        ?>
                        <div class="bx-ui-slider-part p1"><span><?= $value1 ?></span></div>
                        <div class="bx-ui-slider-part p2"><span><?= $value2 ?></span></div>
                        <div class="bx-ui-slider-part p3"><span><?= $value3 ?></span></div>
                        <div class="bx-ui-slider-part p4"><span><?= $value4 ?></span></div>
                        <div class="bx-ui-slider-part p5"><span><?= $value5 ?></span></div>

                        <div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;"
                             id="colorUnavailableActive_<?= $key ?>"></div>
                        <div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;"
                             id="colorAvailableInactive_<?= $key ?>"></div>
                        <div class="bx-ui-slider-pricebar-v" style="left: 0;right: 0;"
                             id="colorAvailableActive_<?= $key ?>"></div>
                        <div class="bx-ui-slider-range" id="drag_tracker_<?= $key ?>" style="left: 0;right: 0;">
                            <a class="bx-ui-slider-handle left" style="left:0;" href="javascript:void(0)"
                               id="left_slider_<?= $key ?>"></a>
                            <a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)"
                               id="right_slider_<?= $key ?>"></a>
                        </div>
                    </div>
                </div>
            <?
            $arJsParams = array(
                "leftSlider" => 'left_slider_' . $key,
                "rightSlider" => 'right_slider_' . $key,
                "tracker" => "drag_tracker_" . $key,
                "trackerWrap" => "drag_track_" . $key,
                "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
                "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
                "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
                "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
                "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                "fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"],
                "fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
                "precision" => $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0,
                "colorUnavailableActive" => 'colorUnavailableActive_' . $key,
                "colorAvailableActive" => 'colorAvailableActive_' . $key,
                "colorAvailableInactive" => 'colorAvailableInactive_' . $key,
            );
            ?>
                <script type="text/javascript">
                    BX.ready(function () {
                        window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
                    });
                </script>
            <?
            break;
            case "B"://NUMBERS
            ?>
                <div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
                    <i class="bx-ft-sub"><?= GetMessage("CT_BCSF_FILTER_FROM") ?></i>
                    <div class="bx-filter-input-container">
                        <input
                                class="min-price"
                                type="text"
                                name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                size="5"
                                onkeyup="smartFilter.keyup(this)"
                        />
                    </div>
                </div>
                <div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
                    <i class="bx-ft-sub"><?= GetMessage("CT_BCSF_FILTER_TO") ?></i>
                    <div class="bx-filter-input-container">
                        <input
                                class="max-price"
                                type="text"
                                name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                size="5"
                                onkeyup="smartFilter.keyup(this)"
                        />
                    </div>
                </div>
            <?
            break;
            case "G"://CHECKBOXES_WITH_PICTURES
            ?>
                <div class="col-xs-12">
                    <div class="bx-filter-param-btn-inline">
                        <? foreach ($arItem["VALUES"] as $val => $ar):?>
                            <input
                                    style="display: none"
                                    type="checkbox"
                                    name="<?= $ar["CONTROL_NAME"] ?>"
                                    id="<?= $ar["CONTROL_ID"] ?>"
                                    value="<?= $ar["HTML_VALUE"] ?>"
                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                            />
                            <?
                            $class = "";
                            if ($ar["CHECKED"])
                                $class .= " bx-active";
                            if ($ar["DISABLED"])
                                $class .= " disabled";
                            ?>
                            <label for="<?= $ar["CONTROL_ID"] ?>" data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                   class="bx-filter-param-label <?= $class ?>"
                                   onclick="smartFilter.keyup(BX('<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')); BX.toggleClass(this, 'bx-active');">
                                                    <span class="bx-filter-param-btn bx-color-sl">
                                                        <? if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
                                                            <span class="bx-filter-btn-color-icon"
                                                                  style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                                        <?endif ?>
                                                    </span>
                            </label>
                        <?endforeach ?>
                    </div>
                </div>
            <?
            break;
            case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
            ?>
                <div class="col-xs-12">
                    <div class="bx-filter-param-btn-block">
                        <? foreach ($arItem["VALUES"] as $val => $ar):?>
                            <input
                                    style="display: none"
                                    type="checkbox"
                                    name="<?= $ar["CONTROL_NAME"] ?>"
                                    id="<?= $ar["CONTROL_ID"] ?>"
                                    value="<?= $ar["HTML_VALUE"] ?>"
                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                            />
                            <?
                            $class = "";
                            if ($ar["CHECKED"])
                                $class .= " bx-active";
                            if ($ar["DISABLED"])
                                $class .= " disabled";
                            ?>
                            <label for="<?= $ar["CONTROL_ID"] ?>" data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                   class="bx-filter-param-label<?= $class ?>"
                                   onclick="smartFilter.keyup(BX('<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')); BX.toggleClass(this, 'bx-active');">
                                                    <span class="bx-filter-param-btn bx-color-sl">
                                                        <? if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
                                                            <span class="bx-filter-btn-color-icon"
                                                                  style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                                        <?endif ?>
                                                    </span>
                                <span class="bx-filter-param-text" title="<?= $ar["VALUE"]; ?>"><?= $ar["VALUE"]; ?><?
                                    if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                        ?> (<span
                                            data-role="count_<?= $ar["CONTROL_ID"] ?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
                                    endif; ?></span>
                            </label>
                        <?endforeach ?>
                    </div>
                </div>
            <?
            break;
            case "P"://DROPDOWN
                $checkedItemExist = false;
            ?>
                <?if ($arParams['SECTION_ID'] === 0):?>
                    <div class="event-page__filter-name"><?= $arItem["NAME"] ?></div>
                <?endif;?>
                <select class="event-select" data-action="changeFilter" id="<?= $arCur["CONTROL_NAME_ALT"] ?>" name="<?= $arCur["CONTROL_NAME_ALT"] ?>"
                        data-fused="<?=$preFilter['PROPERTY_'.$arItem['CODE']] ? 'true' : 'false'?>"
                >
                    <option class="event-select__first" value="all">
                        <?= $arItem['FILTER_HINT'] ? : GetMessage("CT_BCSF_FILTER_ALL") ?>
                    </option>
                    <? foreach ($arItem["VALUES"] as $val => $ar):?>
                        <?if ($arItem['CODE'] === 'UF_SPEAKER' && (int)$_GET['filterSPEAKER'] === (int)$val) $ar["CHECKED"] = true;?>
                        <option
                                data-fc-ufn="fcufn_<?=$arItem['CODE']?>"
                                data-fc-ufv="<?=$val?>"
                                id="<?= $ar["CONTROL_ID"] ?>"
                                value="<? echo $ar["HTML_VALUE_ALT"] ?>"
                            <? echo $ar["CHECKED"] ? 'selected="selected"' : '' ?>
                        >
                            <?= $ar["VALUE"] ?>
                        </option>
                    <?endforeach;?>
                </select>
            <?
            break;
            case "R"://DROPDOWN_WITH_PICTURES_AND_LABELS
            ?>
                <div class="col-xs-12">
                    <div class="bx-filter-select-container">
                        <div class="bx-filter-select-block"
                             onclick="smartFilter.showDropDownPopup(this, '<?= CUtil::JSEscape($key) ?>')">
                            <div class="bx-filter-select-text fix" data-role="currentOption">
                                <?
                                $checkedItemExist = false;
                                foreach ($arItem["VALUES"] as $val => $ar):
                                    if ($ar["CHECKED"]) {
                                        ?>
                                        <? if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
                                            <span class="bx-filter-btn-color-icon"
                                                  style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                        <?endif ?>
                                        <span class="bx-filter-param-text">
                                                                    <?= $ar["VALUE"] ?>
                                                                </span>
                                        <?
                                        $checkedItemExist = true;
                                    }
                                endforeach;
                                if (!$checkedItemExist) {
                                    ?><span class="bx-filter-btn-color-icon all"></span> <?
                                    echo GetMessage("CT_BCSF_FILTER_ALL");
                                }
                                ?>
                            </div>
                            <div class="bx-filter-select-arrow"></div>
                            <input
                                    style="display: none"
                                    type="radio"
                                    name="<?= $arCur["CONTROL_NAME_ALT"] ?>"
                                    id="<? echo "all_" . $arCur["CONTROL_ID"] ?>"
                                    value=""
                            />
                            <? foreach ($arItem["VALUES"] as $val => $ar):?>
                                <input
                                        style="display: none"
                                        type="radio"
                                        name="<?= $ar["CONTROL_NAME_ALT"] ?>"
                                        id="<?= $ar["CONTROL_ID"] ?>"
                                        value="<?= $ar["HTML_VALUE_ALT"] ?>"
                                    <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                />
                            <?endforeach ?>
                            <div class="bx-filter-select-popup" data-role="dropdownContent" style="display: none">
                                <ul>
                                    <li style="border-bottom: 1px solid #e5e5e5;padding-bottom: 5px;margin-bottom: 5px;">
                                        <label for="<?= "all_" . $arCur["CONTROL_ID"] ?>" class="bx-filter-param-label"
                                               data-role="label_<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                               onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape("all_" . $arCur["CONTROL_ID"]) ?>')">
                                            <span class="bx-filter-btn-color-icon all"></span>
                                            <? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
                                        </label>
                                    </li>
                                    <?
                                    foreach ($arItem["VALUES"] as $val => $ar):
                                        $class = "";
                                        if ($ar["CHECKED"])
                                            $class .= " selected";
                                        if ($ar["DISABLED"])
                                            $class .= " disabled";
                                        ?>
                                        <li>
                                            <label for="<?= $ar["CONTROL_ID"] ?>"
                                                   data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                   class="bx-filter-param-label<?= $class ?>"
                                                   onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')">
                                                <? if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
                                                    <span class="bx-filter-btn-color-icon"
                                                          style="background-image:url('<?= $ar["FILE"]["SRC"] ?>');"></span>
                                                <?endif ?>
                                                <span class="bx-filter-param-text">
                                                                        <?= $ar["VALUE"] ?>
                                                                    </span>
                                            </label>
                                        </li>
                                    <?endforeach ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?
            break;
            case "K"://RADIO_BUTTONS
            ?>
                <div class="col-xs-12">
                    <div class="radio">
                        <label class="bx-filter-param-label" for="<? echo "all_" . $arCur["CONTROL_ID"] ?>">
                                                    <span class="bx-filter-input-checkbox">
                                                        <input
                                                                type="radio"
                                                                value=""
                                                                name="<? echo $arCur["CONTROL_NAME_ALT"] ?>"
                                                                id="<? echo "all_" . $arCur["CONTROL_ID"] ?>"
                                                                onclick="smartFilter.click(this)"
                                                        />
                                                        <span class="bx-filter-param-text"><? echo GetMessage("CT_BCSF_FILTER_ALL"); ?></span>
                                                    </span>
                        </label>
                    </div>
                    <? foreach ($arItem["VALUES"] as $val => $ar):?>
                        <div class="radio">
                            <label data-role="label_<?= $ar["CONTROL_ID"] ?>" class="bx-filter-param-label"
                                   for="<? echo $ar["CONTROL_ID"] ?>">
                                                        <span class="bx-filter-input-checkbox <? echo $ar["DISABLED"] ? 'disabled' : '' ?>">
                                                            <input
                                                                    type="radio"
                                                                    value="<? echo $ar["HTML_VALUE_ALT"] ?>"
                                                                    name="<? echo $ar["CONTROL_NAME_ALT"] ?>"
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
            break;
            case "U"://CALENDAR
            ?>
            <?if ($arParams['SECTION_ID'] === 0):?>
                <div class="event-page__filter-name">Календарь</div>
            <?endif;?>
            <input class="event-select" type="text" data-action="changeDateInput"
                   data-dfilter='<?=json_encode($preFilter)?>' placeholder="<?=$arItem['FILTER_HINT']?>" id="date-range-page">
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
