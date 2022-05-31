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

if (!$arResult["NavShowAlways"]) {
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
        return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : "");
?>
<div class="pagination pagination_ctnter" data-entity="pagination" data-container-target="container-<?= $arResult["NavNum"] ?>">
    <? if ($arResult["bDescPageNumbering"] === true) { ?>
        <? if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) { ?>
            <? if ($arResult["bSavePage"]) { ?>
                <a class="pagination__prev"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>">
                    <svg width="14" height="8">
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
                    </svg>
                </a>
                <a class="pagination__number"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["NavPageCount"] ?>">
                    1
                </a>
            <? } else { ?>
                <? if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"] + 1)) { ?>
                    <a class="pagination__prev"
                       href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">
                        <svg width="14" height="8">
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
                        </svg>
                    </a>
                    <a class="pagination__prev"
                       href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">
                        <svg width="14" height="8">
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
                        </svg>
                    </a>
                    <?
                } else {
                    ?>
                    <a class="pagination__prev"
                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>">
                        <svg width="14" height="8">
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
                        </svg>
                    </a>
                <? } ?>
                <? if ($arResult['nStartPage'] < $arResult['NavPageCount']) { ?>
                    <a class="pagination__number"
                       href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">1</a>
                <? } ?>
            <? } ?>
        <? } else { ?>
            <div class="pagination__prev">
                <svg width="14" height="8">
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
                </svg>
            </div>
        <? } ?>
        <? if ($arResult['nStartPage'] < $arResult['NavPageCount'] - 1) { ?>
            <span class="pagination__number">...</span>
        <? } ?>
        <? while ($arResult["nStartPage"] >= $arResult["nEndPage"]) { ?>
            <? $NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1; ?>
            <? if ($arResult["nStartPage"] == $arResult["NavPageNomer"]) { ?>
                <div class="pagination__number"><?= $NavRecordGroupPrint ?></div>
            <? } elseif ($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false) { ?>
                <a class="pagination__number"
                   href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">
                    <?= $NavRecordGroupPrint ?>
                </a>
            <? } else { ?>
                <a class="pagination__number"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>">
                    <?= $NavRecordGroupPrint ?>
                </a>
            <? } ?>
            <? $arResult["nStartPage"]-- ?>
        <? } ?>
        <? if ($arResult['nEndPage'] > 2) { ?>
            <span class="pagination__number">...</span>
        <? } ?>
        <? if ($arResult["NavPageNomer"] > 1) { ?>
            <? if (1 != $arResult['nEndPage']) { ?>
                <a class="pagination__number"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=1">
                    <?= $arResult["NavPageCount"] ?>
                </a>
            <? } ?>
            <a class="pagination__next"
               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>">
                <svg width="14" height="8">
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
                </svg>
            </a>
        <? } else { ?>
            <div class="pagination__next">
                <svg width="14" height="8">
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
                </svg>
            </div>
        <? } ?>
    <? } else { ?>
        <? if ($arResult["NavPageNomer"] > 1) { ?>
            <? if ($arResult["bSavePage"]) { ?>
                <a class="pagination__prev"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>">
                    <svg width="14" height="8">
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
                    </svg>
                </a>
                <a class="pagination__number"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=1">
                    1
                </a>
            <? } else { ?>
                <? if ($arResult["NavPageNomer"] > 2) { ?>
                    <a class="pagination__prev"
                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>">
                        <svg width="14" height="8">
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
                        </svg>
                    </a>
                <? } else { ?>
                    <a class="pagination__prev"
                       href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">
                        <svg width="14" height="8">
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
                        </svg>
                    </a>
                <? } ?>
                <? if (1 != $arResult['nStartPage']) { ?>
                    <a class="pagination__number"
                       href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">
                        1
                    </a>
                <? } ?>
            <? } ?>
        <? } else { ?>
            <span class="pagination__prev">
                <svg width="14" height="8">
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
                </svg>
            </span>
        <? } ?>
        <? if ($arResult['nStartPage'] > 2) { ?>
            <span class="pagination__number">...</span>
        <? } ?>
        <? while ($arResult["nStartPage"] <= $arResult["nEndPage"]) { ?>
            <? if ($arResult["nStartPage"] == $arResult["NavPageNomer"]) { ?>
                <div class="pagination__number"><?= $arResult["nStartPage"] ?></div>
            <? } elseif ($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false) { ?>
                <a class="pagination__number"
                   href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">
                    <?= $arResult["nStartPage"] ?>
                </a>
            <? } else { ?>
                <a class="pagination__number"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>">
                    <?= $arResult["nStartPage"] ?>
                </a>
            <? } ?>
            <? $arResult["nStartPage"]++ ?>
        <? } ?>
        <? if ($arResult['nEndPage'] < $arResult['NavPageCount'] - 1) { ?>
            <span class="pagination__number">...</span>
        <? } ?>
        <? if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) { ?>
            <? if ($arResult['NavPageCount'] != $arResult['nEndPage']) { ?>
                <a class="pagination__number"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["NavPageCount"] ?>">
                    <?= $arResult["NavPageCount"] ?>
                </a>
            <? } ?>
            <a class="pagination__next" 
               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>">
                <svg width="14" height="8">
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
                </svg>
            </a>
        <? } else { ?>
            <div class="pagination__next">
                <svg width="14" height="8">
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
                </svg>
            </div>
        <? } ?>
    <? } ?>
</div>