<?php
namespace Ajax;
use \Ajax\Response;
use Bitrix\Main;

class Catalog
{
    public static function getCatalogForCalendar ()
    {
        $response = new Response();
        try {
            if(!\CModule::IncludeModule("iblock")) throw new Exception('Не подключен модуль iblock');
            $request = Main\Application::getInstance()->getContext()->getRequest();
            $post = $request->getPostList()->toArray();
            if (!empty($post)) {
                $eventsType = getHLElementByName('b_hlbd_eventstype');

                $arSelect = Array("ID", "NAME",
                    "PROPERTY_UF_EVENT_TYPE",
                    "PROPERTY_UF_DATE_ACTIVE",
                    "PROPERTY_UF_SPEAKER",
                    "PROPERTY_UF_TIME_BEF",
                    "PROPERTY_UF_TIME_AFT");
                //$arFilter = Array("ACTIVE"=>"Y", ">=DATE_ACTIVE_TO" => date("Y-m-d"));
                //$arFilter = Array("ACTIVE"=>"Y", ">=PROPERTY_UF_DATE_ACTIVE" => date("Y-m-d"));
                $arFilter = Array("ACTIVE"=>"Y");
                $eventOb = \CIBlockElement::GetList(Array(), array_merge($arFilter, $post), false, Array(), $arSelect);
                while ($eventArr = $eventOb->GetNext()) {
                    //$spikerArr = \CIBlockElement::GetByID($eventArr['PROPERTY_UF_SPEAKER_VALUE'])->GetNext();
                    $spikerArr = \CIBlockElement::GetList(Array(),
                        Array("IBLOCK_ID"=>1, "IBLOCK_TYPE"=>'content', "ID" => $eventArr['PROPERTY_UF_SPEAKER_VALUE']),
                        false, Array(),
                        Array("ID", "NAME", "PROPERTY_UF_CITY")
                    )->GetNext();
                    $spikerName = $spikerArr['NAME'];
                    $spikerName .= $spikerArr['PROPERTY_UF_CITY_VALUE'] ? ' ('.$spikerArr['PROPERTY_UF_CITY_VALUE'].')':'';
                    $time = $eventArr['PROPERTY_UF_TIME_BEF_VALUE'] ? 'с ' . date("H:i", MakeTimeStamp($eventArr['PROPERTY_UF_TIME_BEF_VALUE'])) : '';
                    $time .= $eventArr['PROPERTY_UF_TIME_AFT_VALUE'] ? ' до ' . date("H:i", MakeTimeStamp($eventArr['PROPERTY_UF_TIME_AFT_VALUE'])) : '';
                    $jsonArr[$eventArr['PROPERTY_UF_DATE_ACTIVE_VALUE']][] = [
                        'time' => $time,
                        'tupe' => $eventsType[$eventArr['PROPERTY_UF_EVENT_TYPE_VALUE']]['UF_NAME'] ? : '',
                        'name' => $spikerName ? : '',
                    ];
                }
                return $response->shapeOk($jsonArr, 'Список мероприятий');
            }
        } catch (Exception $e) {
            return $response->shapeError([], $e);
        }
    }
}
