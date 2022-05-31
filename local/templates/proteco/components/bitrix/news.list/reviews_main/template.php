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
<? if (!empty($arResult["ITEMS"])): ?>
    <section class="container-wrap reviews__wrap">
        <div class="container-item reviews">
            <h2 class="h1 reviews__h">Отзывы</h2>
            <div class="reviews-slider__wrap">
                <div class="swiper-container reviews-slider">
                    <div class="swiper-wrapper">
                        <? foreach ($arResult["ITEMS"] as $arItem): ?>
                            <?
                            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                            ?>
                            <div class="swiper-slide" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                                <div class="reviews-slider__item">
                                    <svg class="reviews-slider__quotes" width="32" height="32">
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-quotes"></use>
                                    </svg>
                                    <h3 class="reviews-slider__h"><?=$arItem["NAME"]?></h3>
                                    <p class="reviews-slider__text"><?=$arItem["~PREVIEW_TEXT"]?></p>
                                    <div class="reviews-slider__star" data-star="<?=$arItem['PROPERTIES']['UF_RAITING']['VALUE']?>">
                                        <svg width="17" height="16">
                                            <use xlink:href="./assets/images/sprite.svg#icon-star"></use>
                                        </svg>
                                        <svg width="17" height="16">
                                            <use xlink:href="./assets/images/sprite.svg#icon-star"></use>
                                        </svg>
                                        <svg width="17" height="16">
                                            <use xlink:href="./assets/images/sprite.svg#icon-star"></use>
                                        </svg>
                                        <svg width="17" height="16">
                                            <use xlink:href="./assets/images/sprite.svg#icon-star"></use>
                                        </svg>
                                        <svg width="17" height="16">
                                            <use xlink:href="./assets/images/sprite.svg#icon-star"></use>
                                        </svg>
                                    </div>
                                    <img class="reviews-slider__img" width="120" height="120"
                                         src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ? : '/local/templates/proteco/assets/images/img1.jpg' ?>"
                                         width="<?= $arItem["PREVIEW_PICTURE"]["WIDTH"] ?>"
                                         height="<?= $arItem["PREVIEW_PICTURE"]["HEIGHT"] ?>"
                                         alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                         title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>">
                                    <span class="reviews-slider__name"><?=$arItem['PROPERTIES']['UF_AUTHOR']['VALUE']?></span>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
                <div class="reviews-slider__pagination"></div>
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
        </div>
    </section>
<? endif; ?>
