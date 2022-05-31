<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;
$aMenuLinksExt = array();
$aMenuLinksExt = $APPLICATION->IncludeComponent(
	"bitrix:menu.sections",
	"",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"DEPTH_LEVEL" => "1",
		"DETAIL_PAGE_URL" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#",
		"IBLOCK_ID" => "1",
		"IBLOCK_TYPE" => "content",
		"IS_SEF" => "Y",
		"SECTION_PAGE_URL" => "#SECTION_CODE_PATH#/",
		"SECTION_URL" => "",
		"SEF_BASE_URL" => "/speakers/"
	)
);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
$aMenuLinks[] = Array(
        "Стать спикером",
        "/speakers/#join_klub",
        Array(),
        Array(),
        ""
    );
?>
