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
<ul class="speakers-page__list" data-entity="container-<?= $arResult['NAV_RESULT']->NavNum ?>">
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <li class="speakers-page__item" data-entity="item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
            <img class="speakers-page__item-img" src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                 width="<?= $arItem["PREVIEW_PICTURE"]["WIDTH"] ?>"
                 height="<?= $arItem["PREVIEW_PICTURE"]["HEIGHT"] ?>"
                 alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                 title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>">
            <div class="speakers-page__item-text-wrap">
                <h4 class="speakers-page__item-name"><?= $arItem['NAME'] ?> <?=$arItem['PROPERTIES']['UF_CITY']['VALUE'] ? '('.$arItem['PROPERTIES']['UF_CITY']['VALUE'].')': ''?></h4>
                <p class="speakers-page__item-text"><?= $arItem["~PREVIEW_TEXT"] ?></p>
                <?if ($arItem['HAVE_EVENTS']):?>
                    <a class="speakers-page__item-linc" target="_blank" href="/events/?filterSPEAKER=<?=$arItem['ID']?>">
                        Мероприятия спикера
                        <svg width="14" height="8">
                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-arrow"></use>
                        </svg>
                    </a>
                <?endif;?>
                <?if ($arItem['HAVE_MATERIALS']):?>
                <a class="speakers-page__item-linc" target="_blank" href="/materialy/?SPEAKER=<?=$arItem['ID']?>">
                    Материалы спикера
                    <svg width="14" height="8">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-arrow"></use>
                    </svg>
                </a>
                <?endif;?>
            </div>
        </li>
    <? endforeach; ?>
</ul>
<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
    <?= $arResult["NAV_STRING"] ?>
<? endif; ?>