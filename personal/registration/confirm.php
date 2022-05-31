<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Подтверждение регистрации");
$APPLICATION->AddViewContent('hide_bread', 'style="display: none"');
?>

<?$APPLICATION->IncludeComponent("bitrix:system.auth.confirmation","confirm",Array(
        "USER_ID" => "confirm_user_id",
        "CONFIRM_CODE" => "confirm_code",
        "LOGIN" => "login"
    )
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>