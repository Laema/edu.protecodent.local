<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
//***********************************
//setting section
//***********************************
?>
<div class="mailing__text-wrrap">
    <h2 class="mailing__h">
        <?if ($msg):?>
            <?=$msg?>
        <?else:?>
            Подпишитесь на нашу рассылку, чтобы получить:
        <?endif;?>
    </h2>
    <ul class="mailing__advantages">
        <li class="mailing__advantages-item">
            <div class="mailing__advantages-icon">
                <svg width="16" height="13">
                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-ok"></use>
                </svg>
            </div>
            <span class="mailing__advantages-text">Уведомления о мероприятиях</span>
        </li>
        <li class="mailing__advantages-item">
            <div class="mailing__advantages-icon">
                <svg width="16" height="13">
                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-ok"></use>
                </svg>
            </div>
            <span class="mailing__advantages-text">Полезные статьи</span>
        </li>
        <li class="mailing__advantages-item">
            <div class="mailing__advantages-icon">
                <svg width="16" height="13">
                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-ok"></use>
                </svg>
            </div>
            <span class="mailing__advantages-text">Ссылки на трансляции</span>
        </li>
    </ul>
</div>
<form class="mailing__form" action="<?= $arResult["FORM_ACTION"] ?>" method="post">
    <? echo bitrix_sessid_post(); ?>
    <input class="input mailing__form-input" type="email" name="EMAIL" placeholder="Ваш E-mail"
           value="<?= $arResult["SUBSCRIPTION"]["EMAIL"] != "" ? $arResult["SUBSCRIPTION"]["EMAIL"] : $arResult["REQUEST"]["EMAIL"]; ?>"
    >
    <label style="display: none">
        <? foreach ($arResult["RUBRICS"] as $itemID => $itemValue) { ?>
            <input type="checkbox" name="RUB_ID[]" value="<?= $itemValue["ID"] ?>"
                   checked/><?= $itemValue["NAME"] ?>
        <? } ?>
        <input type="radio" name="FORMAT"
               value="text"<? if ($arResult["SUBSCRIPTION"]["FORMAT"] == "text") echo " checked" ?> />
        <input type="radio" name="FORMAT"
               value="html"<? if ($arResult["SUBSCRIPTION"]["FORMAT"] == "html") echo " checked" ?> />
    </label>
    <span class="mailing__form-text">
                Нажимая на кнопку, я подтверждаю, что согласен на обработку моих персональных данных, а также с
                <a href="<?=$GLOBALS['OPTIONS']['UF_AGREEMENT_URL']['VALUE']?>">Пользовательским соглашением</a>
            </span>
    <input class="button" type="submit" name="Save" value="<?= GetMessage("subscr_subscr") ?>"/>
    <input type="hidden" name="PostAction" value="<? echo($arResult["ID"] > 0 ? "Update" : "Add") ?>"/>
    <input type="hidden" name="ID" value="<? echo $arResult["SUBSCRIPTION"]["ID"]; ?>"/>
    <? if ($_REQUEST["register"] == "YES"): ?>
        <input type="hidden" name="register" value="YES"/>
    <? endif; ?>
    <? if ($_REQUEST["authorize"] == "YES"): ?>
        <input type="hidden" name="authorize" value="YES"/>
    <? endif; ?>
</form>