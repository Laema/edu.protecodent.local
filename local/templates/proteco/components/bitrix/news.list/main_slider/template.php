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
<section class="swiper-container main-slider">
    <div class="swiper-wrapper">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <div class="swiper-slide container-wrap main-slider__item-wrap" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                <div class="container-item main-slider__item">
                    <h1 class="h1 main-slider__h"><?=$arItem['NAME']?></h1>
                    <?if ($arItem['PROPERTIES']['UF_LINK']['VALUE']):?>
                        <a class="button button_wheat main-slider__button" href="<?=$arItem['PROPERTIES']['UF_LINK']['VALUE']?>">Подробнее</a>
                    <?endif;?>
                    <svg class="main-slider__logo" width="648" height="648">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#logo-min"></use>
                    </svg>
                </div>
            </div>
        <? endforeach; ?>
    </div>
</section>
