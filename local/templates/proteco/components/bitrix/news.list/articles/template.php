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

?>
<?php if ($arResult['ITEMS']):?>
<section class="container-wrap article-list__wrap">

    <div class="container-item article-list">
        <?
        $page = $APPLICATION->GetCurUri();
        if ( strpos($page,'materialy') == false):?>
           <h1 class="h1 article-list__h"><?$APPLICATION->showTitle(false) ?></h1>
       <?endif;?>

        <?if (!empty($arResult["ITEMS"])):?>
            <ul class="articles article-list__articles" data-entity="container-1">
                <?foreach($arResult["ITEMS"] as $arItem):?>
                    <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <li class="articles__item" data-entity="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <a class="articles__linc" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                            <img class="articles__img"
                                 src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                                 alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                                 title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>">
                            <div class="articles__text-wrap">
                                <div class="articles__head">
                                    <span class="articles__date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></span>
                                    <?if ($arItem['PROPERTIES']['UF_VIEW_COUNT']['VALUE'] !== '0'):?>
                                        <div class="articles__views">
                                            <svg width="18" height="11">
                                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-eye"></use>
                                            </svg>
                                            <span><?=$arItem['PROPERTIES']['UF_VIEW_COUNT']['VALUE']?></span>
                                        </div>
                                    <?endif;?>
                                </div>
                                <h3 class="articles__h"><?=$arItem["NAME"]?></h3>
                                <p class="articles__text"><?=$arItem["~PREVIEW_TEXT"];?></p>
                            </div>
                        </a>
                    </li>
                <?endforeach;?>
            </ul>
            <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
                <?=$arResult["NAV_STRING"]?>
            <?endif;?>
        <?endif;?>
    </div>

</section>
<?php endif?>
