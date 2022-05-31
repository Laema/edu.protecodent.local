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
?>
<div class="gallery-page__text">
    <?=$arResult["~DETAIL_TEXT"]?:$arResult["~PREVIEW_TEXT"]?>
</div>
<?if (!empty($props['UF_GALERY']['VALUE'])):?>
<div class="gallery-page__gallery" data-list-gallery>
    <?foreach ($props['UF_GALERY']['VALUE'] as $key => $galeryItem):?>
        <?
        $alt = $props['UF_GALERY']['~DESCRIPTION'][$key] ? : $arResult["NAME"];
        $gImg = CFile::GetPath($galeryItem);
        ?>
        <a class="gallery-page__gallery-image" href="<?=$gImg?>" target="_blank"
           data-img-gallery data-sub-html="&lt;p&gt;<?=$alt?>&lt;/p&gt;">
            <img src="<?=$gImg?>" alt="<?=$alt?>">
        </a>
    <?endforeach;?>
</div>
<?endif;?>