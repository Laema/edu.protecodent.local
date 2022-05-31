<?php
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;

if(!empty($_POST)){

    $result = array('status' => 'success');
    $user = new CUser;

    $email = trim(htmlspecialcharsEx($_POST['register-form-email']));
    $password = trim(htmlspecialcharsEx($_POST['register-form-password-input']));

    if(!empty($email)) {
        if(!empty(isRegistered($email))) {

            $eventId = trim(htmlspecialcharsEx($_POST['register-form-event-id']));

            $login = $user->Login($email, $password, 'Y', 'Y');

            if(!empty($login['TYPE'])) {
                $result['status'] = 'error';
                $result['error_type'] = 'log pass mismathc';
                $result['error_description'] = 'Неверный логин или пароль.';
            } else {
                $orderResult = createOrder($USER->GetID(), $eventId);

                if($orderResult['status'] == 'success') {
                    $result['redirect_url'] = $orderResult['redirect_url'];
                }
            }
        } else {
            $result['status'] = 'error';
            $result['error_type'] = 'not registered';
        }
    } else {
        $result['status'] = 'error';
        $result['error_type'] = 'empty email';
        $result['error_description'] = 'Не заполнено поле Email';
    }

    echo json_encode($result);
}
