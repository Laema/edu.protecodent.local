<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


    $event = CIBlockElement::GetList(
        array(),
        array(
            'IBLOCK_ID'=>'3',
            'PROPERTY_UF_SPEAKER' =>  $arResult['DISPLAY_PROPERTIES']['UF_SPIKER']['VALUE'],
            'ACTIVE'=>'Y',
           // '>PROPERTY_UF_TIME_BEF' => date()
        ),
        false,
        false,
        array('ID','PROPERTY_UF_TIME_BEF')
    )->fetch();
    $date = time();

    if (strtotime($event['PROPERTY_UF_TIME_BEF_VALUE']) > $date){
        $arResult['HAVE_EVENTS'] = true;
    }

    $video = CIBlockElement::GetList(
        array(),
        array(
            'IBLOCK_ID'=>'6',
            'PROPERTY_UF_SPIKER' =>  $arResult['DISPLAY_PROPERTIES']['UF_SPIKER']['VALUE'],
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
            'PROPERTY_UF_SPIKER' => $arResult['DISPLAY_PROPERTIES']['UF_SPIKER']['VALUE'],
            'ACTIVE'=>'Y',
        ),
        false,
        false,
        array('ID','PROPERTY_UF_SPIKER')
    )->fetch();

    if ($video or $articles) {
        $arResult['HAVE_MATERIALS'] = true;
    }

