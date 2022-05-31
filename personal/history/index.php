<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("История мероприятий");
if (!$USER->IsAuthorized()) {
    LocalRedirect('/personal/login/');
}
$userEventsInOrder = userEventsInOrders();
$GLOBALS['EVENT_TYPES'] = getHLElementByName('b_hlbd_eventstype');
$GLOBALS['ordersEventsFilter']['ID'] = $userEventsInOrder['EVENTS_ID'];
$GLOBALS['ordersEventsFilter']["<=PROPERTY_UF_TIME_AFT"] = date("Y-m-d H:i");
?><section class="container-wrap lk__wrap">
<div class="container-item lk">
	<h1 class="h1 lk__h">Личный кабинет</h1>
	<div class="lk__content-wrap">
		 <?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"lk",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(0=>"",),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "lk",
		"USE_EXT" => "N"
	)
);?> <? if ($userEventsInOrder['EVENTS_ID']) : ?> <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"personal_orders",
	Array(
		"ACTIVE_DATE_FORMAT" => "j F Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "personal_orders",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"ID",1=>"CODE",2=>"XML_ID",3=>"NAME",4=>"SORT",5=>"DATE_ACTIVE_TO",6=>"ACTIVE_TO",7=>"IBLOCK_TYPE_ID",8=>"IBLOCK_ID",9=>"IBLOCK_CODE",10=>"IBLOCK_NAME",11=>"IBLOCK_EXTERNAL_ID",12=>"",),
		"FILTER_NAME" => "ordersEventsFilter",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "10",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "ajax_nav",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(0=>"UF_EVENT_TYPE",1=>"UF_TIME_AFT",2=>"UF_TIME_BEF",3=>"UF_DATE_ACTIVE",4=>"",),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "PROPERTY_UF_TIME_BEF",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	)
);?> <? else:?>
		<p class="lk__none-text">
			Вы пока не зарегистрированы на участие ни в одном мероприятии.
		</p>
		 <? endif?>
	</div>
</div>
 </section> <br><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>