<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResult['SHOW_FIELDS'] = array(
    'NAME',
    'LAST_NAME',
    'WORK_COMPANY',
    'EMAIL',
    'PERSONAL_COUNTRY',
    'PERSONAL_PHONE',
    'WORK_PROFILE',
    'LOGIN',
    'PASSWORD',
    'CONFIRM_PASSWORD',
    'PERSONAL_CITY'
);
if ($GLOBALS['REGISTER_SUCCESS']) {
    $user = new CUser;
    $user->Update($arResult['VALUES']['USER_ID'], array('ACTIVE'=>'Y'));
    $user->Authorize($arResult['VALUES']['USER_ID']);
    ?>
    <script>
        let postData = new FormData();
        postData.append('ID', <?=$_POST['REGISTER']['ID_EVENT']?>);
        postData.append('TYPE', 'event');
        postData.append('PAYMENT_CHECK', "<?=$_POST['PAYMENT_CHECK']?>");
        ra.ajax('/ajax/?act=Order.addEventInOrder','POST',postData,{},'json').then((response) => {
            if (response.isSuccess && response.result.ORDER_ID !== 0) {
                window.location = response.result.EVENT_URL + '?ORDER_ID=' + response.result.ORDER_ID;
            }
        });
    </script>
<?php
}
