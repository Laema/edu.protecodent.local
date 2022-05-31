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
?>
<section class="container-wrap search-page__wrap">
    <div class="container-item search-page">
        <form class="search-page-input" action="" method="get">
            <? if ($arParams["USE_SUGGEST"] === "Y"):
                if (mb_strlen($arResult["REQUEST"]["~QUERY"]) && is_object($arResult["NAV_RESULT"])) {
                    $arResult["FILTER_MD5"] = $arResult["NAV_RESULT"]->GetFilterMD5();
                    $obSearchSuggest = new CSearchSuggest($arResult["FILTER_MD5"], $arResult["REQUEST"]["~QUERY"]);
                    $obSearchSuggest->SetResultCount($arResult["NAV_RESULT"]->NavRecordCount);
                }
                ?>
                <? $APPLICATION->IncludeComponent(
                "bitrix:search.suggest.input",
                "",
                array(
                    "NAME" => "q",
                    "VALUE" => $arResult["REQUEST"]["~QUERY"],
                    "INPUT_SIZE" => 40,
                    "DROPDOWN_SIZE" => 10,
                    "FILTER_MD5" => $arResult["FILTER_MD5"],
                ),
                $component, array("HIDE_ICONS" => "Y")
            ); ?>
            <? else: ?>
                <input class="search-page-input__input" type="search" name="q"
                       value="<?= $arResult["REQUEST"]["QUERY"] ?>" size="40"/>
            <? endif; ?>
            <? if ($arParams["SHOW_WHERE"]): ?>
                &nbsp;<select name="where">
                    <option value=""><?= GetMessage("SEARCH_ALL") ?></option>
                    <? foreach ($arResult["DROPDOWN"] as $key => $value): ?>
                        <option value="<?= $key ?>"<? if ($arResult["REQUEST"]["WHERE"] == $key) echo " selected" ?>><?= $value ?></option>
                    <? endforeach ?>
                </select>
            <? endif; ?>
            <input class="button search-page-input__button" type="submit" value="<?= GetMessage("SEARCH_GO") ?>"/>
            <input type="hidden" name="how" value="<? echo $arResult["REQUEST"]["HOW"] == "d" ? "d" : "r" ?>"/>
            <? if ($arParams["SHOW_WHEN"]): ?>
                <script>
                    var switch_search_params = function () {
                        var sp = document.getElementById('search_params');
                        var flag;
                        var i;

                        if (sp.style.display == 'none') {
                            flag = false;
                            sp.style.display = 'block'
                        } else {
                            flag = true;
                            sp.style.display = 'none';
                        }

                        var from = document.getElementsByName('from');
                        for (i = 0; i < from.length; i++)
                            if (from[i].type.toLowerCase() == 'text')
                                from[i].disabled = flag;

                        var to = document.getElementsByName('to');
                        for (i = 0; i < to.length; i++)
                            if (to[i].type.toLowerCase() == 'text')
                                to[i].disabled = flag;

                        return false;
                    }
                </script>
                <br/><a class="search-page-params" href="#"
                        onclick="return switch_search_params()"><? echo GetMessage('CT_BSP_ADDITIONAL_PARAMS') ?></a>
                <div id="search_params" class="search-page-params"
                     style="display:<? echo $arResult["REQUEST"]["FROM"] || $arResult["REQUEST"]["TO"] ? 'block' : 'none' ?>">
                    <? $APPLICATION->IncludeComponent(
                        'bitrix:main.calendar',
                        '',
                        array(
                            'SHOW_INPUT' => 'Y',
                            'INPUT_NAME' => 'from',
                            'INPUT_VALUE' => $arResult["REQUEST"]["~FROM"],
                            'INPUT_NAME_FINISH' => 'to',
                            'INPUT_VALUE_FINISH' => $arResult["REQUEST"]["~TO"],
                            'INPUT_ADDITIONAL_ATTR' => 'size="10"',
                        ),
                        null,
                        array('HIDE_ICONS' => 'Y')
                    ); ?>
                </div>
            <? endif ?>
        </form>

        <? if (isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
            ?>
            <div class="search-language-guess">
                <? echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#" => '<a href="' . $arResult["ORIGINAL_QUERY_URL"] . '">' . $arResult["REQUEST"]["ORIGINAL_QUERY"] . '</a>')) ?>
            </div>
        <? endif; ?>

        <? if ($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false): ?>
        <? elseif (count($arResult["SEARCH"]) > 0): ?>
            <ul class="search-page-list" data-entity="container-<?=$arResult['NAV_RESULT']->NavNum?>">
                <? foreach ($arResult["SEARCH"] as $arItem): ?>
                        <?if ($arItem['PARAM2'] == 1):?>
                           <? $arItem['URL'] = '/materialy/?SPEAKER='. $arItem['ITEM_ID']?>
                        <? endif;?>
                    <li class="earch-page-list__item" data-entity="item">
                        <div class="earch-page-list__category">
                            <?=explode('&nbsp;/&nbsp;', $arItem['CHAIN_PATH'])[1]?>
                        </div>
                        <div class="earch-page-list__name"><?=$arItem['~TITLE_FORMATED']?></div>
                        <a class="linc-arrow linc-arrow_back earch-page-list__linc" href="<?=$arItem['URL']?>">
                            <svg width="14" height="8">
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-arrow"></use>
                            </svg>
                            <span>Подробнее</span>
                        </a>
                    </li>
                <? endforeach; ?>
            </ul>
            <?if($arParams["DISPLAY_BOTTOM_PAGER"] != "N"):?>
                <?=$arResult["NAV_STRING"];?>
            <?endif;?>
        <? else: ?>
            <? ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND")); ?>
        <? endif; ?>
    </div>
</section>