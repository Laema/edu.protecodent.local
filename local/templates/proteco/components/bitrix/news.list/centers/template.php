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
    <ul class="centers-page__list" data-entity="container-<?=$arResult['NAV_RESULT']->NavNum?>">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            $props = $arItem['PROPERTIES'];
            if ($props['UF_ONLINE']['VALUE']) {
                $online = $arItem;
                $online['EDIT_ID'] = $this->GetEditAreaId($arItem['ID']);
                continue;
            }
            ?>
            <li class="centers-page__item" data-entity="item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                <?if ($props['UF_MAP']['~VALUE']['TEXT']):?>
                    <div class="centers-page__map">
                        <?=$props['UF_MAP']['~VALUE']['TEXT']?>
                    </div>
                <?endif;?>
                <div class="centers-page__content">
                    <h3 class="centers-page__item-h">Учебный центр в г. <?=$arItem['NAME']?></h3>
                    <?if ($props['UF_ADRES']['~VALUE']):?>
                        <div class="centers-page__item-icon-text">
                            <svg width="18" height="20">
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-point"></use>
                            </svg>
                            <span><?=$props['UF_ADRES']['~VALUE']?></span>
                        </div>
                    <?endif;?>
                    <?if ($props['UF_METRO']['~VALUE']):?>
                        <div class="centers-page__item-icon-text">
                            <svg width="18" height="20">
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-metro"></use>
                            </svg>
                            <span><?=$props['UF_METRO']['~VALUE']?></span>
                        </div>
                    <?endif;?>
                    <div class="centers-page__item-text">
                        <?=$arItem['~PREVIEW_TEXT']?>
                    </div>
                    <?if ($props['UF_PHONE']['VALUE']):?>
                        <a class="centers-page__item-icon-text" href="tel:+<?=preg_replace("/[^0-9]/", '', $props['UF_PHONE']['VALUE'])?>">
                            <svg width="17" height="17">
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-phone"></use>
                            </svg><span><?=$props['UF_PHONE']['VALUE']?></span>
                        </a>
                    <?endif;?>
                    <?if ($props['UF_EMAIL']['VALUE']):?>
                        <a class="centers-page__item-icon-text" href="mailto:<?=$props['UF_EMAIL']['VALUE']?>">
                            <svg width="17" height="17">
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-email"></use>
                            </svg><span><?=$props['UF_EMAIL']['VALUE']?></span>
                        </a>
                    <?endif;?>
                    <?if ($props['UF_GRAFIK']['~VALUE']['TEXT']):?>
                        <div class="centers-page__item-icon-text">
                            <svg width="17" height="17">
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-time"></use>
                            </svg><span>Режим работы: <br><?=$props['UF_GRAFIK']['~VALUE']['TEXT']?></span>
                        </div>
                    <?endif;?>
                </div>
            </li>
        <? endforeach; ?>
    </ul>
    <?if ($online):?>
        <div class="order-training centers-page__order-training" id="<?= $online['EDIT_ID']; ?>">
            <svg class="order-training__logo" width="140" height="140">
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#logo-min"></use>
            </svg>
            <div class="order-training__wrap-text">
                <h3 class="order-training__h">Учебный центр Онлайн</h3>
                <p class="order-training__p"><?=$online['~PREVIEW_TEXT']?></p>
                <button class="button order-training__button" data-action="clickShowPopup" data-popup-name="orderTraining">Заказать обучение</button>
            </div>
        </div>
    <?endif;?>
<? endif; ?>
