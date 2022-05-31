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
<section class="container-wrap faq-page__wrap">
    <div class="container-item faq-page">
        <h1 class="h1 faq-page__h"><? $APPLICATION->showTitle(false) ?></h1>
        <ul class="faq">
            <? foreach ($arResult["ITEMS"] as $arItem): ?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <li class="faq__item ac" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                    <div class="faq__head ac-header ac-trigger">
                        <?= $arItem["NAME"] ?>
                        <svg class="faq__head-icon" width="22" height="14">
                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-arrow"></use>
                        </svg>
                    </div>
                    <div class="faq__body ac-panel">
                        <p class="faq__body-text">
                            <?= $arItem["~PREVIEW_TEXT"] ?>
                        </p>
                    </div>
                </li>
            <? endforeach; ?>
        </ul>
    </div>
</section>
