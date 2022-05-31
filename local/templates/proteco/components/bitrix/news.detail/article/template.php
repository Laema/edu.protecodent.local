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
$views =!empty($props['UF_VIEW_COUNT']['VALUE'])?$props['UF_VIEW_COUNT']['VALUE']:0;
if(!in_array($arResult['ID'],$_SESSION['VIEW'][$arResult['IBLOCK_ID']])) {
    CIBlockElement::SetPropertyValuesEx($arResult['ID'], false, array("UF_VIEW_COUNT" => $props['UF_VIEW_COUNT']['VALUE'] + 1));
    unset($_SESSION['VIEW'][$arResult['IBLOCK_ID']][$arResult['ID']]);
    $_SESSION['VIEW'][$arResult['IBLOCK_ID']][$arResult['ID']] = $arResult['ID'];
    $views++;
}
?>
<h1 class="article-page__h"><?=$arResult["NAME"]?></h1>
<div class="article-page__data">
    <span class="articles__date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
    <?if ($props['UF_VIEW_COUNT']['VALUE'] !== '0'):?>
        <div class="articles__views">
            <svg width="18" height="11">
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-eye"></use>
            </svg><span><?=$props['UF_VIEW_COUNT']['VALUE']?></span>
        </div>
    <?endif;?>
</div>
<div class="article-page__content">
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<img
			src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
			width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
			height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
			alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
			title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
			/>
	<?endif?>
    <?=$arResult["~DETAIL_TEXT"]?:$arResult["~PREVIEW_TEXT"]?>
    <?if (!empty($props['UF_SLIDER']['VALUE'])):?>
        <div class="article-page__slider-wrap">
            <div class="swiper-container article-page__slider">
                <div class="swiper-wrapper">
                    <?foreach ($props['UF_SLIDER']['VALUE'] as $sliderItem):?>
                        <div class="swiper-slide">
                            <img src="<?=CFile::GetPath($sliderItem)?>" alt="<?=$arResult["NAME"]?>">
                        </div>
                    <?endforeach;?>
                </div>
            </div>
            <div class="article-page__slider-pagination">   </div>
            <div class="reviews-slider__prev">
                <svg width="14" height="8">
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
                </svg>
            </div>
            <div class="reviews-slider__next">
                <svg width="14" height="8">
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
                </svg>
            </div>
        </div>
    <?endif;?>
</div>