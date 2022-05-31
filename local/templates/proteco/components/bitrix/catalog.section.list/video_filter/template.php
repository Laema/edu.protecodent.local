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
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')); ?>
<? if (0 < $arResult["SECTIONS_COUNT"]): ?>
    <div class="video-list__filter-bot">
        <? $counter = 0; ?>
        <? foreach ($arResult['SECTIONS'] as $key => &$arSection) {
            if ($arSection['ELEMENT_CNT'] === '0') continue;
            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
            if ($counter === 0) {$GLOBALS['FIRST_VIDEO_SECTION'] = $arSection['ID'];}
            ?>
            <label class="radio-button" id="<?= $this->GetEditAreaId($arSection['ID']) ?>">
                <input class="radio-button__input" type="radio"
                    <?= $counter === 0 ? 'checked' : '' ?>
                       onchange="setSectionFilter(this)" name="video"
                       id="<?= $arSection['ID'] ?>">
                <div class="radio-button__button"><?= $arSection['NAME'] ?></div>
            </label>
            <?
            $counter++;
        }
        unset($arSection); ?>
    </div>
<? endif; ?>