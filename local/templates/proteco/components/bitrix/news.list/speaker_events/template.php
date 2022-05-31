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
    <h2 class="event-page__h2">Другие мероприятия спикера</h2>
    <div class="reviews-slider__wrap">
        <div class="swiper-container event-page-slider">
            <div class="swiper-wrapper">
                <? foreach ($arResult["ITEMS"] as $arItem): ?>
                    <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <div class="swiper-slide">
                        <? $APPLICATION->IncludeComponent(
                            'bitrix:catalog.item',
                            'events',
                            array(
                                'RESULT' => array(
                                    'ITEM' => $arItem,
                                    'AREA_ID' => $this->GetEditAreaId($arItem['ID']),
                                    'TYPE' => 'card',
                                    'BIG_LABEL' => 'N',
                                    'BIG_DISCOUNT_PERCENT' => 'N',
                                    'BIG_BUTTONS' => 'N',
                                    'SCALABLE' => 'N'
                                )
                            ),
                            false,
                            array('HIDE_ICONS' => 'Y')
                        ); ?>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
        <div class="reviews-slider__pagination"></div>
        <div class="reviews-slider__prev">
            <svg width="14" height="8">
                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-arrow"></use>
            </svg>
        </div>
        <div class="reviews-slider__next">
            <svg width="14" height="8">
                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-arrow"></use>
            </svg>
        </div>
    </div>
<? endif; ?>