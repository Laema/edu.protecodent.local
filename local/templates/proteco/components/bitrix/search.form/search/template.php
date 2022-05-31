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
$this->setFrameMode(true); ?>
<form class="header__search" action="<?= $arResult["FORM_ACTION"] ?>">
    <? if ($arParams["USE_SUGGEST"] === "Y"): ?>
        <? $APPLICATION->IncludeComponent(
            "bitrix:search.suggest.input",
            "",
            array(
                "NAME" => "q",
                "VALUE" => "",
                "INPUT_SIZE" => 15,
                "DROPDOWN_SIZE" => 10,
            ),
            $component, array("HIDE_ICONS" => "Y")
        ); ?>
    <? else: ?>
        <input class="header__search-input" id="header-search" type="search" name="q" placeholder="Найти" value="" size="15" maxlength="50"/>
    <? endif; ?>
    <input style="display: none" name="s" type="submit" value="<?= GetMessage("BSF_T_SEARCH_BUTTON"); ?>"/>
    <label class="header__search-wrap" for="header-search">
        <svg class="header__search-icon" width="20" height="20">
            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-search"></use>
        </svg>
    </label>
    <svg class="header__search-icon-cancel" width="20" height="20">
        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-cancel-button"></use>
    </svg>
</form>