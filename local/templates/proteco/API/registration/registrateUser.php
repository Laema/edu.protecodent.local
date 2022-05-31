<?php
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;

if(!empty($_POST)){

    $result = array('status' => 'success');
    $user = new CUser;
    $password = RandString(6);

    $email = trim(htmlspecialcharsEx($_POST['register-form-email']));
    $name = trim(htmlspecialcharsEx($_POST['register-form-username']));
    $lastName = trim(htmlspecialcharsEx($_POST['register-form-last-name']));

    $company = trim(htmlspecialcharsEx($_POST['register-form-company']));
    $phone = trim(htmlspecialcharsEx($_POST['register-form-phone']));
    $organization = trim(htmlspecialcharsEx($_POST['register-form-organization-type']));
    $city = trim(htmlspecialcharsEx($_POST['register-form-city']));
    $eventId = trim(htmlspecialcharsEx($_POST['register-form-event-id']));
    $referrer = trim(htmlspecialcharsEx($_POST['register-form-referrer']));

    if(!empty($email)) {
        if(empty(isRegistered($email))) {
            $arFields = array(
                "NAME" => $name,
                "LAST_NAME" => $lastName,
                "LOGIN" => $email,
                "EMAIL" => $email,
                "PERSONAL_PHONE" => $phone,
                "ACTIVE" => "Y",
                "PASSWORD" => $password,
                "CONFIRM_PASSWORD" => $password,
                "PERSONAL_CITY" => $city,
                "WORK_COMPANY" => $company,
                "WORK_PROFILE" => $organization,
                "GROUP_ID" => array(3, 4, 5),
                "UF_REFERRER" => $referrer,
            );
            $newUserID = $user->Add($arFields);

            if(!empty($newUserID)) {
                $SITE_ID = 's1';
                $EVEN_TYPE = 'SUCCESSFUL_REGISTRATION';
                $arFeedForm = array(
                    "CUSTOMER_EMAIL" => $email,
                    "CUSTOMER_PASS" => $password,
                );
                CEvent::Send($EVEN_TYPE, $SITE_ID, $arFeedForm );

                $login = $user->Login($email, $password, 'Y', 'Y');

                $orderResult = createOrder($newUserID, $eventId);

                if($orderResult['status'] == 'success') {
                    $result['redirect_url'] = $orderResult['redirect_url'];
                }
            }

        } else {
            $result['status'] = 'error';
            $result['error_type'] = 'already registered';
        }

    } else {
        $result['status'] = 'error';
        $result['error_type'] = 'empty email';
        $result['error_description'] = 'Не заполнено поле Email';
    }

    echo json_encode($result);

}
