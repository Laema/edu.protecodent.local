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
<ul class="gallery-list__list" data-entity="container-<?= $arResult['NAV_RESULT']->NavNum ?>">
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <li class="gallery-list__item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>" data-entity="item">
            <h3 class="gallery-list__item-h"><?= $arItem["NAME"] ?></h3>
            <div class="gallery-list__item-img-wrap" data-list-gallery>
                <?foreach ($arItem['PROPERTIES']['UF_GALERY']['VALUE'] as $key => $galeryItem):?>
                    <?
                    if($key < 4){
                        $alt = $arItem['PROPERTIES']['UF_GALERY']['~DESCRIPTION'][$key] ? : $arItem["NAME"];
                        $gImg = CFile::GetPath($galeryItem);
                        ?>
                        <a class="gallery-list__item-image" href="<?=$gImg?>" target="_blank" data-img-gallery
                           data-sub-html="&lt;p&gt;<?=$alt?>&lt;/p&gt;">
                            <img src="<?=$gImg?>" alt="<?=$alt?>">
                        </a>
                    <?
                        }
                    endforeach;?>
                <a class="gallery-list__item-linc" href="<?=$arItem['DETAIL_PAGE_URL']?>">Смотреть весь альбом</a></div>
        </li>
    <? endforeach; ?>
</ul>
<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
    <?= $arResult["NAV_STRING"] ?>
<? endif; ?>
