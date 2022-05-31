<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$page = $APPLICATION->GetCurUri();
$sections = CIBlockSection::GetList(
    array(),
    array('IBLOCK_ID'=>6
    )
);
while ($section = $sections->GetNext()) {
    $resultSections[$section['ID']] = $section['CODE'];
}

if ( strpos($page,'materialy') !== false) {

    foreach ($arResult['ITEMS'] as $key => $arItem) {
        $arResult['ITEMS'][$key]['DETAIL_PAGE_URL'] = '/video/'.$resultSections[$arItem['IBLOCK_SECTION_ID']].'/'.$arItem['CODE'].'/';
    }
}
// 
// foreach ($arResult['ITEMS'] as $key => $arItem) {
//     $arPhoto = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'],
//     array("width"=>270,"height"=>200),
//     BX_RESIZE_IMAGE_EXACT);
//     $arResult['ITEMS'][$key]["PREVIEW_PICTURE"]["SRC"]=$arPhoto['src'];
// }
