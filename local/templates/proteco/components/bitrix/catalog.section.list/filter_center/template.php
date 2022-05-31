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

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));
if (0 < $arResult["SECTIONS_COUNT"]): ?>
    <div class="speakers-page__filter">
        <?if ($arParams['SHOW_ALL'] === 'Y'):?>
            <label class="radio-button">
                <input class="radio-button__input" type="radio" name="video" onchange="setSectionFilter(this)" id="all" checked>
                <div class="radio-button__button">Все</div>
            </label>
        <?endif;?>
        <?foreach ($arResult['SECTIONS'] as &$arSection)
        {
            if ($arSection['ELEMENT_CNT'] === '0') continue;
            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
            ?>
            <label class="radio-button" id="<?=$this->GetEditAreaId($arSection['ID'])?>">
                <a href = '/centers/<?=$arSection['CODE']?>/' class="radio-button__button"><?=$arSection['NAME']?></a>
            </label>
        <?
        }
        unset($arSection);?>
    </div>
<?endif;?>