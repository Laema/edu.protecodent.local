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
<ul class="podcast-list__list" data-entity="container-<?=$arResult['NAV_RESULT']->NavNum ? : 'video-main'?>">
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        
        $arFilter = Array("IBLOCK_ID"=>1, "ID" => $arItem['PROPERTIES']['UF_SPIKER']['VALUE'], "ACTIVE"=>"Y");
        $speakerOb = CIBlockElement::GetList(Array(), $arFilter, false, Array(), Array());
        $speaker = $speakerOb->GetNext();
        ?>
        <li class="podcast-list__list-item" data-entity="item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
            <h4 class="podcast-list__list-h"><?= $arItem["NAME"] ?></h4>
            <div class="podcast-list__list-body">
                <img class="podcast-list__list-img" src="<?=CFile::GetPath($speaker['PREVIEW_PICTURE'])?>" alt="<?=$speaker['NAME']?>" width="125" height="175">
                <div class="podcast-list__list-info">
                    <div class="podcast-list__list-name"><?=$speaker['NAME']?></div>
                    <div class="podcast-list__list-description"><?=$speaker['~PREVIEW_TEXT']?></div>
                    <div class="podcast-list__list-button-wrap">
                        <a class="button podcast-list__list-button" href="<?= $arItem["DETAIL_PAGE_URL"] ?>">Слушать</a>
                        <?if ($arItem['PROPERTIES']['UF_FILE_LONG']['VALUE']): ?>
                            <span class="podcast-list__list-time">
                                  Длительность: <?=declOfNum($arItem['PROPERTIES']['UF_FILE_LONG']['VALUE'], ['минута', 'минуты', 'минут'])?>
                            </span>
                        <?endif;?>
                    </div>
                </div>
            </div>
        </li>
    <? endforeach; ?>
</ul>
<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
    <?= $arResult["NAV_STRING"] ?>
<? endif; ?>