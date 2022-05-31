<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $USER;

foreach ($arResult['ITEMS'] as $key => $item) {
    $event = CIBlockElement::GetList(
        array('PROPERTY_UF_DATE_ACTIVE' => 'desc'),
        array(
            'IBLOCK_ID'=>'3',
            'PROPERTY_UF_SPEAKER' => $item['ID'],
            'ACTIVE'=>'Y',
           // '>PROPERTY_UF_TIME_BEF' => date()
        ),
        false,
        false,
        array('ID','PROPERTY_UF_DATE_ACTIVE')
    )->fetch();
    $date = time();
    if (strtotime($event['PROPERTY_UF_DATE_ACTIVE_VALUE']) > $date){
        $arResult['ITEMS'][$key]['HAVE_EVENTS'] = true;
    }

    $video = CIBlockElement::GetList(
        array(),
        array(
            'IBLOCK_ID'=>'6',
            'PROPERTY_UF_SPIKER' => $item['ID'],
            'ACTIVE'=>'Y',
        ),
        false,
        false,
        array('ID','PROPERTY_UF_SPIKER')
    )->fetch();

    $articles = CIBlockElement::GetList(
        array(),
        array(
            'IBLOCK_ID'=>'4',
            'PROPERTY_UF_SPIKER' => $item['ID'],
            'ACTIVE'=>'Y',
        ),
        false,
        false,
        array('ID','PROPERTY_UF_SPIKER')
    )->fetch();

    if ($video or $articles) {
        $arResult['ITEMS'][$key]['HAVE_MATERIALS'] = true;
    }
}
