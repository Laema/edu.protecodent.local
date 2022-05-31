<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER["DOCUMENT_ROOT"].'/upload/paymentChecks/1'.'.'.$extension);
if(file_exists($_SERVER["DOCUMENT_ROOT"].'/upload/paymentChecks/1'.'.'.$extension)){
    $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].'/upload/paymentChecks/1'.'.'.$extension);
    $file = CFile::SaveFile($arFile, 'paymentChecks');

    echo 'https://edu.protecodent.ru'.CFile::GetPath($file);
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
