<?php
$_SERVER["HTTPS"] = "On";
define ('CASHBACK_PERCENT', 3);
use Bitrix\Main;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity,

    Bitrix\Main\Context,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem;

Bitrix\Main\Loader::includeModule("sale");
Bitrix\Main\Loader::includeModule("catalog");


AddEventHandler("sale", "OnSaleStatusOrder", "sendOrderWithCheckToWebinarRu");
function sendOrderWithCheckToWebinarRu($orderId, $orderStatus)
{
    $isCheckNeeded = false;

    $obBasket = \Bitrix\Sale\Basket::getList(array('filter' => array('ORDER_ID' => $orderId)));
    while($bItem = $obBasket->Fetch()){
        $items[] = $bItem;
    }

    $vebinarID = $items[0]['PRODUCT_ID'];

    $db_props = CIBlockElement::GetProperty(3, $vebinarID, array("sort" => "asc"), Array("CODE"=>"IS_CHECK_NEEDED"));
    $ar_props = $db_props->Fetch();
    $isCheckNeeded = $ar_props["VALUE"];

    if(!empty($isCheckNeeded) && $orderStatus == 'F') {

        $arOrder = CSaleOrder::GetByID($orderId);

        $uId = $arOrder['USER_ID'];
        $rsUser = CUser::GetByID($uId);
        $arUser = $rsUser->Fetch();

        $db_props = CIBlockElement::GetProperty(3, $vebinarID, array("sort" => "asc"), Array("CODE"=>"WEB_RU_WEBINAR_ID"));
        $ar_props = $db_props->Fetch();
        $eventSessionId = $ar_props["VALUE"];

        if(!empty($arUser) && !empty($eventSessionId)) {

            $webinarRuUserId = registerUserToEventSessionOnWebinarRu($arUser, $eventSessionId);

            if(!empty($webinarRuUserId)){

                $user = new CUser;
                $user->Update($uId, array('UF_CONTACT_ID_IN_WEBINAR_RU' => $webinarRuUserId));
            }

        }

    }

}


function formatPhoneForHref($phoneNumber)
{
    $search  = array('-', ' ', '(', ')');
    $replace = array('', '', '', '', '');
    $hrefTel =  str_replace($search, $replace, $phoneNumber);
    return $hrefTel;
}

function checkIsUserExistInB24($email)
{
    $response = false;

    $queryUrl = 'https://crm.protecodent.ru/rest/1/26bh8023zmmp310b/crm.contact.list.json';
    $queryData = http_build_query(array(
            'order' => array("DATE_CREATE" => "ASC"),
            'filter' => array('EMAIL' => $email),
            'select' => array("ID")
        )
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,
    ));

    $result = json_decode(curl_exec($curl));
    curl_close($curl);

    if(!empty($result->result)) {
        $response = $result->result[0];
        $response = $response->ID;
    }

    return $response;
}



AddEventHandler("iblock", "OnAfterIBlockElementAdd", "sendLearningOrderToB24");
function sendLearningOrderToB24(&$fields)
{
    if($fields["IBLOCK_ID"] == 17) {
        $queryUrl = 'https://crm.protecodent.ru/rest/1/26bh8023zmmp310b/crm.lead.add.json';

        $workProfile = '';

        if($fields["PROPERTY_VALUES"]["FORM_COMPANY_TYPE"] == 'Дистрибьютор') {
            $workProfile = 320;
        } elseif($fields["PROPERTY_VALUES"]["FORM_COMPANY_TYPE"] == 'Клиника') {
            $workProfile = 322;
        }

        $email = $fields["PROPERTY_VALUES"]["FORM_EMAIL"];


        $fieldsToCURL = array(
            "TITLE" => "Edu.protecodent.ru - заказать обучение в своей клинике",
            "STATUS_ID" => "NEW",
            'SOURCE_ID' => 'edu.protecodent',
            "COMMENTS" => $fields["PREVIEW_TEXT"]
        );


        $contactId = checkIsUserExistInB24($email);

        if(!empty($contactId)) {
            $fieldsToCURL['CONTACT_ID'] = $contactId;
        } else {
            $fieldsToCURL['NAME'] = $fields["PROPERTY_VALUES"]["NAME"];
            $fieldsToCURL['COMPANY_TITLE'] = $fields["PROPERTY_VALUES"]["FORM_COMPANY_NAME"];
            $fieldsToCURL['EMAIL'] = array(array("VALUE" => $email, "VALUE_TYPE" => "WORK"));
            $fieldsToCURL['PHONE'] = array(array("VALUE" => $fields["PROPERTY_VALUES"]["FORM_PHONE"], "VALUE_TYPE" => "WORK"));
            $fieldsToCURL['UF_CRM_1640265138240'] = $workProfile;
        }

        $queryData = http_build_query(array(
            'fields' => $fieldsToCURL,
            'params' => array("REGISTER_SONET_EVENT" => "Y")
        ));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $queryUrl,
            CURLOPT_POSTFIELDS => $queryData,
        ));

        $result2 = curl_exec($curl);
        curl_close($curl);
    }
}


AddEventHandler("iblock", "OnAfterIBlockElementAdd", "sendToB24");
function sendToB24(&$fields)
{

    if($fields["IBLOCK_ID"] == 14) {

        $queryUrl = 'https://crm.protecodent.ru/rest/1/26bh8023zmmp310b/crm.lead.add.json';

        $workProfile = '';

        if($fields["PROPERTY_VALUES"]["FORM_COMPANY_TYPE"] == 'Дистрибьютор') {
            $workProfile = 320;
        } elseif($fields["PROPERTY_VALUES"]["FORM_COMPANY_TYPE"] == 'Клиника') {
            $workProfile = 322;
        }

        $fileLinks = '';

        foreach ($fields["PROPERTY_VALUES"]["FORM_DOCS"] as $file) {
            $fileLinks = str_replace('/home/p/pantel0g/edu.protecodent.ru/public_html/upload/slam.easyform', 'https://edu.protecodent.ru/upload/slam.easyform', $file['tmp_name']);
        }

        $email = $fields["PROPERTY_VALUES"]["FORM_EMAIL"];

        $fieldsToCURL = array(
            "TITLE" => "Edu.protecodent.ru - прислать свой кейс",
            "STATUS_ID" => "NEW",
            'SOURCE_ID' => 'edu.protecodent',
            "UF_LEAD_LINK" => $fileLinks,
            "COMMENTS" => $fields["PREVIEW_TEXT"]
        );

        $contactId = checkIsUserExistInB24($email);

        if(!empty($contactId)) {
            $fieldsToCURL['CONTACT_ID'] = $contactId;
        } else {
            $fieldsToCURL['NAME'] = $fields["PROPERTY_VALUES"]["NAME"];
            $fieldsToCURL['COMPANY_TITLE'] = $fields["PROPERTY_VALUES"]["FORM_COMPANY_NAME"];
            $fieldsToCURL['PHONE'] = array(array("VALUE" => $fields["PROPERTY_VALUES"]["FORM_PHONE"], "VALUE_TYPE" => "WORK"));

            $fieldsToCURL['EMAIL'] = array(array("VALUE" => $email, "VALUE_TYPE" => "WORK"));
            $fieldsToCURL['UF_CRM_1640265138240'] = $workProfile;
        }

        $queryData = http_build_query(array(
            'fields' => $fieldsToCURL,
            'params' => array("REGISTER_SONET_EVENT" => "Y")
        ));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $queryUrl,
            CURLOPT_POSTFIELDS => $queryData,
        ));

        $result2 = curl_exec($curl);
        curl_close($curl);
    }

    if($fields["IBLOCK_ID"] == 18) {

        $queryUrl = 'https://crm.protecodent.ru/rest/1/26bh8023zmmp310b/crm.lead.add.json';

        $workProfile = '';

        $email = $fields["PROPERTY_VALUES"]["FORM_EMAIL"];

        $fieldsToCURL = array(
            "TITLE" => "Edu.protecodent.ru - Стать спикером",
            "STATUS_ID" => "NEW",
            'SOURCE_ID' => 'edu.protecodent',
            "COMMENTS" => $fields["PREVIEW_TEXT"]
        );

        $contactId = checkIsUserExistInB24($email);

        if(!empty($contactId)) {
            $fieldsToCURL['CONTACT_ID'] = $contactId;
        } else {
            $fieldsToCURL['NAME'] = $fields["NAME"];
            $fieldsToCURL['COMPANY_TITLE'] = $fields["PROPERTY_VALUES"]["FORM_COMPANY_NAME"];
            $fieldsToCURL['PHONE'] = array(array("VALUE" => $fields["PROPERTY_VALUES"]["FORM_PHONE"], "VALUE_TYPE" => "WORK"));
            $fieldsToCURL['UF_LEAD_CITY'] = $fields["PROPERTY_VALUES"]["FORM_CITY"];
            $fieldsToCURL['EMAIL'] = array(array("VALUE" => $email, "VALUE_TYPE" => "WORK"));
            $fieldsToCURL['UF_CRM_1640265138240'] = $workProfile;
        }

        $queryData = http_build_query(array(
            'fields' => $fieldsToCURL,
            'params' => array("REGISTER_SONET_EVENT" => "Y")
        ));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $queryUrl,
            CURLOPT_POSTFIELDS => $queryData,
        ));

        $result2 = curl_exec($curl);
        curl_close($curl);
    }

}

function createOrder($userId, $productId)
{
    $result['status'] = 'success';

    $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PAGE_URL", "PROPERTY_BITRIX24_ID");
    $arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "ID" => $productId);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement()){
        $ar_res = $ob->GetFields();
    }

    $res = CIBlockElement::GetProperty(3, $productId, "sort", "asc", array("CODE" => "UF_REGISTER_PAY"));
    $ob = $res->Fetch();

    $price = $ob['VALUE'];

    $isCheckNeeded = false;
    $res = CIBlockElement::GetProperty(3, $productId, "sort", "asc", array("CODE" => "IS_CHECK_NEEDED"));
    $ob = $res->Fetch();

    $isCheckNeeded = $ob['VALUE'];

    $siteId = Context::getCurrent()->getSite();
    $currencyCode = CurrencyManager::getBaseCurrency();

    $order = Order::create($siteId, $userId);
    $order->setPersonTypeId(1);
    $order->setField('CURRENCY', $currencyCode);

    $basket = Basket::create($siteId);
    $item = $basket->createItem('content', $productId);

    $fieldsArray = array(
        'QUANTITY' => 1,
        'CURRENCY' => $currencyCode,
        'LID' => $siteId,
        'NAME' => $ar_res['NAME'],
        'PRODUCT_PROVIDER_CLASS' => '\CCatalogProductProvider',
    );

    if(!empty($price)) {
        $fieldsArray['BASE_PRICE'] = $price;
    } else {
        $order->setField("STATUS_ID", "F");
    }

    if(!empty($isCheckNeeded)) {
        $order->setField("STATUS_ID", "PP");
    }

    $item->setFields($fieldsArray);
    $order->setBasket($basket);

    if(!empty($price)) {
        $paymentCollection = $order->getPaymentCollection();
        $payment = $paymentCollection->createItem();

        $paySystemService = PaySystem\Manager::getObjectById(2);
        $payment->setFields(array(
            'PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"),
            'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
            'SUM' => $price
        ));
    }

    $order->doFinalAction(true);
    $orderResult = $order->save();
    $orderId = $order->getId();

    if(!empty($orderId)) {
        $result['redirect_url'] = $ar_res['DETAIL_PAGE_URL'].'?ORDER_ID='.$orderId;
    } else {
        $result['status'] = 'error';
    }
    return $result;
}

AddEventHandler("sale", "OnOrderSave", "sendOrderToB24");

function sendOrderToB24($oderId, $arFields, $orderFields)
{
    $order = Bitrix\Sale\Order::load($oderId);
    $propertyCollection = $order->getPropertyCollection();
    $somePropValue = $propertyCollection->getItemByOrderPropertyId(1);

    $rsUser = CUser::GetByID($arFields['USER_ID']);
    $user = $rsUser->Fetch();

    $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PAGE_URL", "PROPERTY_BITRIX24_ID");
    $arFilter = Array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "ID" => $orderFields['BASKET_ITEMS'][0]['PRODUCT_ID']);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement()){
        $ar_res = $ob->GetFields();
    }
    $phone = $user["PERSONAL_PHONE"];
    // $formatedPhone = formatPhoneForHref($phone);
    $name = $user["NAME"];
    $email = $user["EMAIL"];
    $queryUrl = 'https://crm.protecodent.ru/rest/1/26bh8023zmmp310b/crm.lead.add.json';

    $fieldsToCURL = array(
        "TITLE" => "Edu.protecodent.ru - запись на курс",
        "UF_CRM_1640329879050" => trim($ar_res['NAME']),
        "STATUS_ID" => "NEW",
        'SOURCE_ID' => 'edu.protecodent',
        'UF_CRM_1642060073047' => $ar_res['PROPERTY_BITRIX24_ID_VALUE'],
        'UF_LEAD_LINK' => trim($somePropValue->getValue())
    );

    $workProfile = '';

    if($user['WORK_PROFILE'] == 'Дистрибьютор') {
        $workProfile = 320;
    } elseif($user['WORK_PROFILE'] == 'Клиника') {
        $workProfile = 322;
    }

    $contactId = checkIsUserExistInB24($email);

    if(!empty($contactId)) {
        $fieldsToCURL['CONTACT_ID'] = $contactId;
    } else {
        $fieldsToCURL['NAME'] = $name;
        $fieldsToCURL['LAST_NAME'] = $user["LAST_NAME"];
        $fieldsToCURL['PHONE'] = array(array("VALUE" => $phone, "VALUE_TYPE" => "WORK"));
        // $fieldsToCURL['UF_NUMBER_FOR_SEARCH'] = $formatedPhone;
        $fieldsToCURL['UF_CRM_1640255273170'] = $user['PERSONAL_CITY'];
        $fieldsToCURL['EMAIL'] = array(array("VALUE" => $user['EMAIL'], "VALUE_TYPE" => "WORK"));
        $fieldsToCURL['COMPANY_TITLE'] = $user['WORK_COMPANY'];
        $fieldsToCURL['UF_CRM_1640265138240'] = $workProfile;
    }

    $queryData = http_build_query(array(
        'fields' => $fieldsToCURL,
        'params' => array("REGISTER_SONET_EVENT" => "Y")
    ));

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,
    ));

    $result2 = curl_exec($curl);
    curl_close($curl);

}

function isRegistered($email)
{
    $user = new CUser;
    $result = true;

    $filter = Array ("EMAIL" => $email);
    $rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), $filter);
    $arUser = $rsUsers->Fetch();

    if(empty($arUser)){
        $result = false;
    }

    return $result;
}


AddEventHandler("subscribe", "OnStartSubscriptionAdd", 'addSubscriberToActivCamp');


function declOfNum ($number, $words) {
    return $number . ' ' . $words[($number % 100 > 4 && $number % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][($number % 10 < 5) ? $number % 10 : 5]];
}
function printApart ($price) {
    return number_format(floatval(str_replace(' ', '', $price)), 0, ',', ' ');
}

function siteOptions () {
    if (CModule::IncludeModule("iblock")) {
        $arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_*");
        $arFilter = Array("IBLOCK_ID" => 8, "ID" => 32, "ACTIVE" => "Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        if($ob = $res->GetNextElement()){
            return $ob->GetProperties();
        }
    }
}

function userOrderStatus ($id) {
    if (CModule::IncludeModule("sale")) {
        global $USER;
        $arFilter = array(
            "USER_ID" => $USER->GetID(),
            'BASKET_PRODUCT_ID' => $id
        );
        $db_sales = CSaleOrder::GetList(array(), $arFilter);
        if ($userOrder = $db_sales->Fetch()) {
            $order = Bitrix\Sale\Order::load($userOrder['ID']);
            $paymentCollection = $order->getPaymentCollection();
            $response['ORDER_ID'] = $userOrder['ID'];

            if ($paymentCollection->getSum() != $paymentCollection->getPaidSum()) {
                $response['STATUS'] = 'NEED_PAY';
            } else {
                $response['STATUS'] = 'PAYED';
            }
            /*if ((int)$userOrder['PRICE'] > 0) {
                if ($userOrder['PAYED'] === 'Y') {
                    $status = 'ONLINE';
                } else {
                    $status = 'NEED_PAY';
                }
            } else {
                if ($userOrder['STATUS_ID'] === 'F') {
                    $status = 'ONLINE';
                }
            }*/
            return $response;
        } else {
            return false;
        }
    }
}

function userAllOrders () {
    if (CModule::IncludeModule("sale")) {
        global $USER;
        $arFilter = array(
            "USER_ID" => $USER->GetID()
        );
        $res = CSaleOrder::GetList(array(), $arFilter);
        $orders = [];
        while ($userOrder = $res->Fetch()) {
            $orders[] = $userOrder;
        }
        return $orders;
    }
}

function userEventsInOrders () {
    if (CModule::IncludeModule("sale")) {
        global $USER;
        $res = CSaleBasket::GetList(array(), array("USER_ID" => $USER->GetID()));
        $basket = [];
        while ($basketItems = $res->Fetch()) {
            $basket['EVENTS_ARR'][] = $basketItems;
            $basket['EVENTS_ID'][] = $basketItems['PRODUCT_ID'];
        }
        return $basket;
    }
}

function isOnline ($timeB, $timeA) {
    if ($timeB && $timeA) {
        $unixB = strtotime($timeB);
        $unixA = strtotime($timeA);
        $time = time();
        return $unixB <= $time && $unixA >= $time;
    }
}

function isClosed ($time) {
    return strtotime($time) < time();
}

function getUserBonuses ($id) {
    CModule::IncludeModule("sale");
    $dbAccountCurrency = CSaleUserAccount::GetList(
        array(),
        array("USER_ID" => $id),
        false,
        false,
        array("CURRENT_BUDGET", "CURRENCY")
    );

    if ($arAccountCurrency = $dbAccountCurrency->Fetch()) {
        return $arAccountCurrency["CURRENT_BUDGET"] ? round($arAccountCurrency["CURRENT_BUDGET"], 2) : 0;
    } else {
        return 0;
    }
}

function addUserBonus($userID, $points, $orderId) {
    if (CModule::IncludeModule('sale')) {
        CSaleUserAccount::UpdateAccount(
            $userID,
            $points,
            'RUB',
            "ORDER_PAY",
            $orderId
        );
    }
}

function getHLElementByName ($HLiB_name, $filter = []){
    if (!$HLiB_name) return false;
    if (CModule::IncludeModule("highloadblock") ) {
        $rsData = HL\HighloadBlockTable::getList(array('filter'=>array('TABLE_NAME'=>$HLiB_name)));
        if ( !($hldata = $rsData->fetch()) ){
            return 'Инфоблок не найден';
        }
        else{
            $hlentity = HL\HighloadBlockTable::compileEntity($hldata);
            $hlDataClass = $hldata['NAME'].'Table';
            $res = $hlDataClass::getList(array(
                    'filter' => $filter,
                    'select' => array("*"),
                    'order' => array(
                        'UF_NAME' => 'asc'
                    ),
                )
            );
            while($row = $res->fetch()) {
                $el[$row['UF_XML_ID']] = $row;
            }
            return $el;
        }
    }else return false;
}

function getHLElementByID ( $id , $filter = []){
    if ($id==0) return false;
    if (CModule::IncludeModule("highloadblock") ) {
        $hlblock = HL\HighloadBlockTable::getById($id)->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entityClass = $entity->getDataClass();
        $res = $entityClass::getList(array('select' => array('*'), 'filter' => $filter));
        $row = $res->fetchAll();
        return $row;
    }else return false;
}

\Bitrix\Main\EventManager::getInstance()->addEventHandler('sale', 'OnSaleOrderEntitySaved', 'OnStatusChange');



function OnStatusChange(Bitrix\Main\Event $event)
{
    $arEmailFields = array();
    $order = $event->getParameter("ENTITY");
    $oldValues = $event->getParameter("VALUES");
    $arOrderVals = $order->getFields()->getValues();

    if ($arOrderVals['STATUS_ID'] == "P" && CModule::IncludeModule('sale')) {
        //if (CModule::IncludeModule('sale')) {
        $money = $order->getPrice();
        $priceAdd = ($money * (CASHBACK_PERCENT / 100)); //вычисление процентов

        $res = CSaleUserTransact::GetList(
            array("ID" => "DESC"),
            array(
                "USER_ID" => $order->getUserId(),
                "ORDER_ID" => $order->getId(),
            ),
            false,
            array("nPageSize" => 1)
        );

        $transfer = $res->fetch();

        if (!$transfer || $transfer['DEBIT'] == "N") {
            addUserBonus($order->getUserId(), $priceAdd, $order->getId());
        }
    }
}

AddEventHandler("iblock", "OnAfterIBlockElementAdd", "coursUpdate");
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "coursUpdate");

function coursUpdate(&$fields)
{
    if (CModule::IncludeModule("iblock") && $fields['IBLOCK_ID'] === '9') {
        foreach ($fields['PROPERTY_VALUES'][38] as $eventId) {
            if ($eventId['VALUE']) {
                $eventIDArr[] = (int)$eventId['VALUE'];
            }
        }
        if (!empty($eventIDArr)) {
            $arFilter = Array("IBLOCK_ID"=>3, "ID"=>$eventIDArr, "ACTIVE"=>"Y");
            $eventObArr = CIBlockElement::GetList(Array(), $arFilter, false, Array(), Array());
            while($eventOb = $eventObArr->GetNextElement())
            {
                $eventFields = $eventOb->GetFields();
                $eventProps = $eventOb->GetProperties();
                $eventCourses = $eventProps['UF_IN_COURSE']['VALUE'];
                $eventCoursesNewArr = [];
                if (!empty($eventCourses)) {
                    $eventCoursesNewArr = $eventCourses;
                }
                if (!in_array($fields['ID'], $eventCoursesNewArr)) {
                    $eventCoursesNewArr[] = $fields['ID'];
                }
                CIBlockElement::SetPropertyValuesEx(
                    $eventFields['ID'],
                    $eventFields['IBLOCK_ID'],
                    array('UF_IN_COURSE' => $eventCoursesNewArr)
                );
                unset($eventCoursesNewArr);
            }
        }
    }
}

function mp3FileDuration($file) {
    $fileInfo = CFile::MakeFileArray($file);
    $ratio = 9000;
    $file_size = $fileInfo['size'];
    $duration = ($file_size / $ratio);
    $minutes = floor($duration / 60);
    $seconds = $duration - ($minutes * 60);
    $seconds = round($seconds);
    return "$minutes:$seconds";
}

function timeDuration($UF_TIME_BEF, $UF_TIME_AFT) {
    $dateBef = new DateTime($UF_TIME_BEF);
    $tempTime = $dateBef->diff(new DateTime($UF_TIME_AFT));
    if ($tempTime->h) {
        $durationTime = declOfNum($tempTime->h, ['час', 'часа', 'часов']);
    }
    if ($tempTime->i) {
        if ($durationTime) {
            $durationTime .= ' ' . declOfNum($tempTime->i, ['минута', 'минуты', 'минут']);
        } else {
            $durationTime = declOfNum($tempTime->i, ['минута', 'минуты', 'минут']);
        }
    }
    return $durationTime;
}

AddEventHandler("main", "OnBeforeUserRegister", "OnBeforeUserRegisterHandler");
function OnBeforeUserRegisterHandler($args)
{
    // $GLOBALS['REGISTER_ERROR'] = "Пользователь с данной почтой уже зарегистрирован!";
    $data = CUser::GetList(($by = "ID"), ($order = "ASC"),
        array(
            "EMAIL" => $args['EMAIL']
        )
    );
    if ($arUser = $data->Fetch()) {
        $GLOBALS['REGISTER_ERROR'] = "Пользователь с данной почтой уже зарегистрирован!";
        return false;
    }
    $GLOBALS['REGISTER_SUCCESS'] = true;
    return true;
}

function getArchiveIDs($filter) {
    if (CModule::IncludeModule("iblock")){
        $arSelect = Array("ID");
        $arFilter = Array("IBLOCK_ID"=>3,
            "IBLOCK_TYPE"=>"content","ACTIVE"=>"Y",
            "<=PROPERTY_UF_DATE_ACTIVE" => date("Y-m-d"));
        $eventOb = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while ($eventArr = $eventOb->GetNext()) {
            $idArr[] = $eventArr['ID'];
        }
        return $idArr;
    }
}

function SendPostRequest( $type, $data = array() ) {
	$result = false;
	$url = 'https://osnostd41.activehosted.com/api/3/'.$type;
	$data = json_encode($data);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Api-Token: 573fd6bf9ed6a876cf129aa7910857799785276c3d191e268593338f162600f1f42b3d23'
	));
	if ( $data ) :
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	endif;
	$output = curl_exec($ch);
	curl_close($ch);
	$result = json_decode($output, true);

	return $result;
}

function SendGetRequest( $type, $data = array() ) {
	$result = false;

	$url = 'https://osnostd41.activehosted.com/api/3/'.$type;

	if ( !empty($data) ) :
		$data = http_build_query($data);
		$url .= '/?'. $data;
	endif;

	//GET request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Api-Token: 573fd6bf9ed6a876cf129aa7910857799785276c3d191e268593338f162600f1f42b3d23'
	));
	$output = curl_exec($ch);
	curl_close($ch);

	$result = json_decode($output, true);

	return $result;
}
function BizonLogin() {
	$url = 'https://online.bizon365.ru/api/v1/auth/login';

	$data = array(
		'username' => 'osnos@protecodent.ru',
		'password' => 'Sm0BvX_Zw'
	);

	$data = http_build_query($data);

	if (!$curld = curl_init()) {
		exit;
	}

	$verbose = fopen('php://temp', 'w+');
	curl_setopt_array($curld, array(
		CURLOPT_URL => $url,
		CURLOPT_POST => TRUE,
		CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
		CURLOPT_POSTFIELDS => $data,
		CURLOPT_VERBOSE => true,
		CURLOPT_STDERR => $verbose
	));

	$output = curl_exec($curld);
	curl_close($curld);

	if ( $output === FALSE ) {
		printf("cUrl error (#%d): %s<br>\n", curl_errno($curld),
		htmlspecialchars(curl_error($curld)));
	}

	rewind($verbose);
	$verboseLog = stream_get_contents($verbose);

	$cookies = array();
	preg_match_all('/Set-Cookie:(?<cookie>\s{0,}.*)$/im', $verboseLog, $cookies);

	$bizonCoockie = $cookies['cookie'][0];

	# Verbose debug info
	# echo "Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";

	return $bizonCoockie;
}

function BizonLogout() {
	$url = 'https://online.bizon365.ru/api/v1/auth/logout';

	if (!$curld = curl_init()) {
		exit;
	}

	curl_setopt_array($curld, array(
		CURLOPT_URL => $url,
		CURLOPT_POST => TRUE,
		CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
	));

	$output = curl_exec($curld);
	curl_close($curld);

	if ( $output === FALSE ) {
		printf("cUrl error (#%d): %s<br>\n", curl_errno($curld),
		htmlspecialchars(curl_error($curld)));
	}

	# Verbose debug info
	# echo "Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";

	return $output;
}
function bizonVebinarRegistration( $data ) {
	$url = 'https://online.bizon365.ru/api/v1/webinars/subpages/addSubscriber';

	if (!$curld = curl_init()) {
		exit;
	}

	$coockie = BizonLogin();

	$verbose = fopen('php://temp', 'w+');
	curl_setopt_array($curld, array(
		CURLOPT_URL => $url,
		CURLOPT_POST => TRUE,
		CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json',
			'Cookie: '.$coockie
		),
		CURLOPT_POSTFIELDS => json_encode($data),
		CURLOPT_VERBOSE => true,
		CURLOPT_STDERR => $verbose
	));

	$output = curl_exec($curld);
	curl_close($curld);

	if ( $output === FALSE ) {
		printf("cUrl error (#%d): %s<br>\n", curl_errno($curld),
		htmlspecialchars(curl_error($curld)));
	}

	rewind($verbose);
	$verboseLog = stream_get_contents($verbose);

	BizonLogout();

	return $output;
}

function addTagToAC($tagName, $contactId)
{

	$search = [
		"search" => $tagName
	];
	$tagId = false;
	$existingTagsArr = SendGetRequest('tags', $search);
	if(empty($existingTagsArr['tags'])) {
		$tagData = [
			"tag" =>[
				"tag" => $tagName,
				"tagType" => "contact",
				"description" => $tagName
			]
		];
		$tagAddResult = SendPostRequest( 'tags', $tagData );
		$tagId = $tagAddResult['tag']['id'];
	} else {
		$tagId = $existingTagsArr['tags'][0]['id'];
	}

	if(!empty($tagId)) {
		$fieldData = [
			"contactTag" => [
				"contact" => $contactId,
				"tag" => $tagId
			]
		];
		SendPostRequest( 'contactTags', $fieldData );
	}
}

function removeTagFromACContact($tagName, $contactId)
{
	$search = [
		"search" => $tagName
	];
	$tagId = false;
	$existingTagsArr = SendGetRequest('tags', $search);
	if(empty($existingTagsArr['tags'])) {
		$tagData = [
			"tag" =>[
				"tag" => $tagName,
				"tagType" => "contact",
				"description" => $tagName
			]
		];
		$tagAddResult = SendPostRequest( 'tags', $tagData );
		$tagId = $tagAddResult['tag']['id'];
	} else {
		$tagId = $existingTagsArr['tags'][0]['id'];
	}

	$tags = SendGetRequest('contacts/'.$contactId.'/contactTags');
	$tagLinkId = false;

	foreach ($tags['contactTags'] as $tag) {
		if($tag['tag'] == $tagId){
			$tagLinkId = $tag['id'];
		}
	}

	$url = 'https://osnostd41.activehosted.com/api/3/contactTags/'.$tagLinkId;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Api-Token: 573fd6bf9ed6a876cf129aa7910857799785276c3d191e268593338f162600f1f42b3d23'
	));

	$output = curl_exec($ch);
	curl_close($ch);

	return 'delete';
}

function updateTagInACAfterPayment($elementName, $contactId)
{
	$elementName = str_replace(',', '', $elementName);

	$result = array('delete' => false, 'add' => false);

	$result['delete'] = removeTagFromACContact($elementName.' заказал', $contactId);
	$result['add'] = addTagToAC($elementName.' оплатил', $contactId);

	return $result;
}

function getAddtionalFieldKey($eventSessionId, $fieldLabel)
{
    $fieldKey = false;

    $url = 'https://userapi.webinar.ru/v3/eventsessions/'.$eventSessionId;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'x-auth-token: b8b7e9c95a5bdc6d73c1c912398d9939'
    ));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);
    curl_close($ch);

    $output = json_decode($output);
    $additionalFields = $output->additionalFields;

    foreach ($output->additionalFields as $field) {
        if($field->label == $fieldLabel) {
            $fieldKey = $field->key;
        }
    }

    return $fieldKey;
}

function registerUserToEventSessionOnWebinarRu($userObj, $eventSessionId)
{
    $contactId = false;

    getAddtionalFieldKey($eventSessionId, 'Название организации');

    if(empty($userObj['EMAIL'])){
        $userObj['EMAIL'] = 'не задано';
    }
    if(empty($userObj['NAME'])){
        $userObj['NAME'] = 'не задано';
    }
    if(empty($userObj['LAST_NAME'])){
        $userObj['LAST_NAME'] = 'не задано';
    }
    if(empty($userObj['WORK_COMPANY'])){
        $userObj['WORK_COMPANY'] = 'не задано';
    }
    if(empty($userObj['PERSONAL_PHONE'])){
        $userObj['PERSONAL_PHONE'] = 'не задано';
    }
    if(empty($userObj['WORK_COMPANY'])){
        $userObj['WORK_COMPANY'] = 'не задано';
    }
    if(empty($userObj['PERSONAL_PHONE'])){
        $userObj['PERSONAL_PHONE'] = 'не задано';
    }
    if(empty($userObj['WORK_PROFILE'])){
        $userObj['WORK_PROFILE'] = 'не задано';
    }
    if(empty($userObj['PERSONAL_CITY'])){
        $userObj['PERSONAL_CITY'] = 'не задано';
    }
    if(empty($userObj['WORK_POSITION'])){
        $userObj['WORK_POSITION'] = 'не задано';
    }

    $data = array(
        'email' => $userObj['EMAIL'],
        'name' => $userObj['NAME'],
        'secondName' => $userObj['LAST_NAME'],
        'sendEmail' => 'true',
        'organization' => $userObj['WORK_COMPANY'],
        'position' => $userObj['WORK_POSITION'],
        'phone' => $userObj['PERSONAL_PHONE'],
        'additionalFields['.getAddtionalFieldKey($eventSessionId, 'Название организации').']' => $userObj['WORK_COMPANY'],
        'additionalFields['.getAddtionalFieldKey($eventSessionId, 'Ваш телефон').']' => $userObj['PERSONAL_PHONE'],
        'additionalFields['.getAddtionalFieldKey($eventSessionId, 'Тип организации').']' => $userObj['WORK_PROFILE'],
        'additionalFields['.getAddtionalFieldKey($eventSessionId, 'Город').']' => $userObj['PERSONAL_CITY'],
    );

    $url = 'https://userapi.webinar.ru/v3/eventsessions/'.$eventSessionId.'/register';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'x-auth-token: b8b7e9c95a5bdc6d73c1c912398d9939'
    ));

    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);
    curl_close($ch);

    $output = json_decode($output);

    $contactId = $output->contactId;

    return $contactId;
}


\Bitrix\Main\EventManager::getInstance()->addEventHandler('sale', 'OnSaleOrderSaved', 'addDataToActivCampAndBizon');
\Bitrix\Main\EventManager::getInstance()->addEventHandler('sale', 'OnSaleOrderSaved', 'addDataToActivCampAndBizonPayed');

function addDataToActivCampAndBizon(Main\Event $event)
{

    if($event->getParameter("IS_NEW")) {

        $webinarRuUserId = $contactId = false;

        $order = $event->getParameter("ENTITY");

        $obBasket = \Bitrix\Sale\Basket::getList(array('filter' => array('ORDER_ID' => $order->getField('ID'))));
        while($bItem = $obBasket->Fetch()){
            $items[] = $bItem;
        }

        $vebinarID = $items[0]['PRODUCT_ID'];

        $db_props = CIBlockElement::GetProperty(3, $vebinarID, array("sort" => "asc"), Array("CODE"=>"IS_CHECK_NEEDED"));
        $ar_props = $db_props->Fetch();
        $isCheckNeeded = $ar_props["VALUE"];

        if(!empty($isCheckNeeded)) {
            return;
        }

        $oldValues = $event->getParameter("VALUES");

        $arOrder = CSaleOrder::GetByID($order->getField('ID'));

        $uId = $arOrder['USER_ID'];
        $rsUser = CUser::GetByID($uId);
        $arUser = $rsUser->Fetch();
        // $elementData = GetIBlockElement($vebinarID);
        $db_props = CIBlockElement::GetProperty(3, $vebinarID, array("sort" => "asc"), Array("CODE"=>"ROOM_TAG"));
        $ar_props = $db_props->Fetch();
        $roomTag = $ar_props["VALUE"];

        $db_props = CIBlockElement::GetProperty(3, $vebinarID, array("sort" => "asc"), Array("CODE"=>"WEB_RU_WEBINAR_ID"));
        $ar_props = $db_props->Fetch();
        $eventSessionId = $ar_props["VALUE"];

        $db_props = CIBlockElement::GetProperty(3, $vebinarID, array("sort" => "asc"), Array("CODE"=>"UF_TIME_BEF"));
        $ar_props = $db_props->Fetch();
        $dateTimeVebinar = $ar_props["VALUE"];
        $date =date('c',strtotime($dateTimeVebinar));

        //если новый и бесплатный вебинар - пишем сразу в бизон
        if($arOrder["PRICE"] == 0){
            $contactId = addDataToActivCamp($arUser, $items[0]['NAME'], false);
            $webinarRuUserId = registerUserToEventSessionOnWebinarRu($arUser, $eventSessionId);

            $bizonData = [
                'pageId' => '62403:'.$roomTag,
                'confirm' => 0,
                'email' => $arUser['EMAIL'],
                'time' => $date
            ];

            bizonVebinarRegistration($bizonData);
        }else{
            $contactId = addDataToActivCamp($arUser, $items[0]['NAME'], true);
        }
        $user = new CUser;
        $fields = Array();
        if(!empty($contactId)){
            $fields['UF_AC_ID'] = $contactId;
        }
        if(!empty($webinarRuUserId)){
            $fields['UF_CONTACT_ID_IN_WEBINAR_RU'] = $webinarRuUserId;
        }

        $user->Update($uId, $fields);
    }
}
function addDataToActivCampAndBizonPayed(Main\Event $event)
{
        $order = $event->getParameter("ENTITY");
        $oldValues = $event->getParameter("VALUES");
        if(!$order->getField('PAYED') || !$oldValues['PAYED'] || !(($order->getField('PAYED')=='Y') && ($oldValues['PAYED']=='N')))
            return;

        // if(!$order->getField('PAYED') || !$oldValues['PAYED'] || !(($order->getField('PAYED')=='Y') && ($oldValues['PAYED']=='N'))){

        $arOrder = CSaleOrder::GetByID($order->getField('ID'));
        $obBasket = \Bitrix\Sale\Basket::getList(array('filter' => array('ORDER_ID' => $order->getField('ID'))));

        while($bItem = $obBasket->Fetch()){
            $items[] = $bItem;
        }

        $uId = $arOrder['USER_ID'];
        $vebinarID = $items[0]['PRODUCT_ID'];
        $rsUser = CUser::GetByID($uId);
        $arUser = $rsUser->Fetch();

        // $elementData = GetIBlockElement($vebinarID);
        $db_props = CIBlockElement::GetProperty(3, $vebinarID, array("sort" => "asc"), Array("CODE"=>"ROOM_TAG"));
        $ar_props = $db_props->Fetch();

        $roomTag = $ar_props["VALUE"];
        $db_props = CIBlockElement::GetProperty(3, $vebinarID, array("sort" => "asc"), Array("CODE"=>"UF_TIME_BEF"));
        $ar_props = $db_props->Fetch();
        $dateTimeVebinar = $ar_props["VALUE"];
        $date = date('c',strtotime($dateTimeVebinar));

        // addDataToActivCamp($arUser,$items[0]['NAME'], true);


        updateTagInACAfterPayment($items[0]['NAME'],$arUser['UF_AC_ID']);

        	$bizonData = [
    		    'pageId' => '62403:'.$roomTag,
    			'confirm' => 0,
    		    'email' => $arUser['EMAIL'],
    		    'time' => $date
    		];

            $vebinarID = $items[0]['PRODUCT_ID'];
            $rsUser = CUser::GetByID($uId);
            $arUser = $rsUser->Fetch();
            // $elementData = GetIBlockElement($vebinarID);
            $db_props = CIBlockElement::GetProperty(3, $vebinarID, array("sort" => "asc"), Array("CODE"=>"ROOM_TAG"));
            $ar_props = $db_props->Fetch();
            $roomTag = $ar_props["VALUE"];

            $db_props = CIBlockElement::GetProperty(3, $vebinarID, array("sort" => "asc"), Array("CODE"=>"WEB_RU_WEBINAR_ID"));
            $ar_props = $db_props->Fetch();
            $eventSessionId = $ar_props["VALUE"];

            $db_props = CIBlockElement::GetProperty(3, $vebinarID, array("sort" => "asc"), Array("CODE"=>"UF_TIME_BEF"));
            $ar_props = $db_props->Fetch();
            $dateTimeVebinar = $ar_props["VALUE"];
            $date =date('c',strtotime($dateTimeVebinar));

        $webinarRuUserId = registerUserToEventSessionOnWebinarRu($arUser, $eventSessionId);
    	// bizonVebinarRegistration($bizonData);
    // }
}


function addSubscriberToActivCamp($arFields)
{
	$contactData = array('contact' => array('email' => $arFields['EMAIL']));
	$contUpdate = SendPostRequest( 'contact/sync', $contactData );
	if(!empty($contUpdate['contact']['id'])) {
		$contactListUp = [
			'contactList' => [
				'list' => 12,
				'contact' => $contUpdate['contact']['id'],
				'status' => 1
			]
		];
		SendPostRequest( 'contactLists', $contactListUp );
	}
}
function addDataToActivCamp($arUser, $vebinarName, $paid=false)
{

	$userName = $userEmail = '';
	$fieldData = array();

    $userName = $arUser['LAST_NAME'] . ' '. $arUser['NAME'];
    $userEmail = $arUser['EMAIL'];

    $contactData = array('contact' => array('email' => $userEmail, 'first_name' => $userName));
    $userPhone = $arUser['PERSONAL_PHONE'];
    if(!empty($userPhone)) {
        $contactData['contact']['phone'] = $userPhone;
    }

	$contactData['contact']['fieldValues'][] = array('field' => 2, 'value' => $arUser['WORK_PROFILE']);
	$contactData['contact']['fieldValues'][] = array('field' => 5, 'value' => $arUser['WORK_COMPANY']);
	$contactData['contact']['fieldValues'][] = array('field' => 14, 'value' => $arUser['WORK_PROFILE']);
	$contactData['contact']['fieldValues'][] = array('field' => 1, 'value' => $arUser['PERSONAL_CITY']);

	$contUpdate = SendPostRequest( 'contact/sync', $contactData );

	if(!empty($contUpdate['contact']['id'])) {

		$contactListUp = [
			'contactList' => [
				'list' => 1,
				'contact' => $contUpdate['contact']['id'],
				'status' => 1
			]
		];
		SendPostRequest( 'contactLists', $contactListUp );

		$postscript = ' записался';

		if(!empty($paid)) {
			$postscript = ' заказал';
		}

		$tagName = str_replace(',', '', $vebinarName).$postscript;
		addTagToAC($tagName, $contUpdate['contact']['id']);

		return $contUpdate['contact']['id'];

	}
}


function webinarRuMakeEvent($fields)
{
    $eventId = false;
    $dateFrom = new DateTime($fields['PROPERTY_VALUES'][2]['n0']['VALUE']);
    $dateTo = new DateTime($fields['PROPERTY_VALUES'][3]['n0']['VALUE']);
    $duration = $dateFrom->diff($dateTo);
    $db_props = CIBlockElement::GetProperty(1, $fields['PROPERTY_VALUES'][4]['n0']['VALUE'], array("sort" => "asc"), Array("CODE"=>"WEBINAR_RU_SPEAKER_ID"));
    $ar_props = $db_props->Fetch();
    $data = array(
        'name' => $fields['NAME'],
        'access' => 4,
        'additionalFields[0][label]' => 'Название организации',
        'additionalFields[0][type]' => 'text',
        'additionalFields[1][label]' => 'Ваш телефон',
        'additionalFields[1][type]' => 'text',
        'additionalFields[2][label]' => 'Тип организации',
        'additionalFields[2][type]' => 'text',
        'additionalFields[3][label]' => 'Город',
        'additionalFields[3][type]' => 'text',
        'startsAt[date][year]' => $dateFrom->format('Y'),
        'startsAt[date][month]' => $dateFrom->format('n'),
        'startsAt[date][day]' => $dateFrom->format('j'),
        'startsAt[time][hour]' => $dateFrom->format('G'),
        'startsAt[time][minute]' => intval($dateFrom->format('i')),
        'endsAt[date][year]' => $dateTo->format('Y'),
        'endsAt[date][month]' => $dateTo->format('n'),
        'endsAt[date][day]' => $dateTo->format('j'),
        'endsAt[time][hour]' => $dateTo->format('G'),
        'endsAt[time][minute]' => intval($dateTo->format('i')),
        'duration' => $duration->format('PT%hH%iM%sS'),
        // 'lectorIds[0]' => $ar_props['VALUE'],
    );

    $url = 'https://userapi.webinar.ru/v3/events';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'x-auth-token: b8b7e9c95a5bdc6d73c1c912398d9939'
    ));

    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);

    curl_close($ch);

    $output = json_decode($output);
    $eventId = $output->eventId;

    if(!empty($eventId)) {
        CIBlockElement::SetPropertyValuesEx($fields['ID'], false, array('WEB_RU_WEBINAR_EVENT_ID' =>$eventId));
    }

    return $eventId;
}

function webinarRuMakeEventSession($eventId, $elementId) {
    $data = array(
        'access' => 4,
    );
    $url = 'https://userapi.webinar.ru/v3/events/'.$eventId.'/sessions';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'x-auth-token: b8b7e9c95a5bdc6d73c1c912398d9939'
    ));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);
    curl_close($ch);

    $output = json_decode($output);
    $eventSessionId = $output->eventSessionId;

    if(!empty($eventSessionId)) {
        CIBlockElement::SetPropertyValuesEx($elementId, false, array('WEB_RU_WEBINAR_ID' => $eventSessionId));
    }
}

AddEventHandler("iblock", "OnAfterIBlockElementAdd", "addEventSessionToWebinarRu");
function addEventSessionToWebinarRu(&$fields)
{

    if (CModule::IncludeModule("iblock") && $fields['IBLOCK_ID'] == 3) {

        $eventId = webinarRuMakeEvent($fields);

        if(!empty($eventId)) {
            $result = webinarRuMakeEventSession($eventId, $fields['ID']);
        }
    }
}

AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "editEventInWebinarRu");
function editEventInWebinarRu(&$fields)
{
    if (CModule::IncludeModule("iblock") && $fields['IBLOCK_ID'] == 3) {

        $eventId = array_values($fields['PROPERTY_VALUES'][65]);
        $eventId = $eventId[0]['VALUE'];

        $eventSessionId = array_values($fields['PROPERTY_VALUES'][64]);
        $eventSessionId = $eventSessionId[0]['VALUE'];

        $dateFrom = array_values($fields['PROPERTY_VALUES'][2]);
        $dateFrom = new DateTime($dateFrom[0]['VALUE']);

        $dateTo = array_values($fields['PROPERTY_VALUES'][3]);
        $dateTo = new DateTime($dateTo[0]['VALUE']);

        $duration = $dateFrom->diff($dateTo);

        $speakerId = array_values($fields['PROPERTY_VALUES'][4]);
        $speakerId = $speakerId[0]['VALUE'];

        $db_props = CIBlockElement::GetProperty(1, $speakerId, array("sort" => "asc"), Array("CODE"=>"WEBINAR_RU_SPEAKER_ID"));
        $ar_props = $db_props->Fetch();

        $data = array(
            'name' => $fields['NAME'],
            'access' => 4,

            'additionalFields[0][label]' => 'Название организации',
            'additionalFields[0][type]' => 'text',
            'additionalFields[1][label]' => 'Ваш телефон',
            'additionalFields[1][type]' => 'text',
            'additionalFields[2][label]' => 'Тип организации',
            'additionalFields[2][type]' => 'text',
            'additionalFields[3][label]' => 'Город',
            'additionalFields[3][type]' => 'text',

            'startsAt[date][year]' => $dateFrom->format('Y'),
            'startsAt[date][month]' => $dateFrom->format('n'),
            'startsAt[date][day]' => $dateFrom->format('j'),
            'startsAt[time][hour]' => $dateFrom->format('G'),
            'startsAt[time][minute]' => intval($dateFrom->format('i')),

            'endsAt[date][year]' => $dateTo->format('Y'),
            'endsAt[date][month]' => $dateTo->format('n'),
            'endsAt[date][day]' => $dateTo->format('j'),
            'endsAt[time][hour]' => $dateTo->format('G'),
            'endsAt[time][minute]' => intval($dateTo->format('i')),
            'duration' => $duration->format('PT%hH%iM%sS'),
            // 'lectorIds[0]' => $ar_props['VALUE'],

        );

        $url = 'https://userapi.webinar.ru/v3/organization/events/'.$eventId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'x-auth-token: b8b7e9c95a5bdc6d73c1c912398d9939'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));

        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $output = curl_exec($ch);

        curl_close($ch);

        $url = 'https://userapi.webinar.ru/v3/eventsessions/'.$eventSessionId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'x-auth-token: b8b7e9c95a5bdc6d73c1c912398d9939'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));

        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $output = curl_exec($ch);
        curl_close($ch);

    }
}
