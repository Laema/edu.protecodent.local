<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<section class="container-wrap">
    <div class="container-item mailing">
        <? $msg = '';
        foreach ($arResult["MESSAGE"] as $itemID => $itemValue)
            $msg .= '<p style="color: green;">'.$itemValue.'</p>';
        foreach ($arResult["ERROR"] as $itemID => $itemValue)
            $msg .= $msg .= '<p style="color: red;">'.$itemValue.'</p>';
        //whether to show the forms
        if ($arResult["ID"] == 0 && empty($_REQUEST["action"]) || CSubscription::IsAuthorized($arResult["ID"])) {
            //show confirmation form
            if ($arResult["ID"] > 0 && $arResult["SUBSCRIPTION"]["CONFIRMED"] <> "Y") {
                include("confirmation.php");
            } else {
                //setting section
                include("setting.php");
            }
        }
        ?>
    </div>
</section>
