<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$page = $APPLICATION->GetCurUri();

if ( strpos($page,'materialy') !== false) {
    foreach ($arResult['ITEMS'] as $key => $arItem) {

        $arResult['ITEMS'][$key]['DETAIL_PAGE_URL'] = '/articles/'.$arItem['CODE'].'/';
    }
}