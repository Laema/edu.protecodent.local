<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
//*************************************
//show confirmation form
//*************************************
?>
<div class="mailing__text-wrrap">
    <h2 class="mailing__h">
        <?if ($msg):?>
            <?=$msg?>
        <?else:?>
            <?=GetMessage("subscr_title_confirm") ?>:
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
<form class="mailing__form" action="<?= $arResult["FORM_ACTION"] ?>" method="get">
    <input class="input mailing__form-input" type="text" name="CONFIRM_CODE"
           placeholder="<? echo GetMessage("subscr_conf_code") ?>" required
           value="<? echo $arResult["REQUEST"]["CONFIRM_CODE"]; ?>"
    />
    <span class="mailing__form-text">
    <p><? echo GetMessage("subscr_conf_date") ?>: <? echo $arResult["SUBSCRIPTION"]["DATE_CONFIRM"]; ?></p>

    <? echo GetMessage("subscr_conf_note1") ?>
    <a title="<? echo GetMessage("adm_send_code") ?>"
            href="<? echo $arResult["FORM_ACTION"] ?>?ID=<? echo $arResult["ID"] ?>&amp;action=sendcode&amp;<? echo bitrix_sessid_get() ?>">
        <? echo GetMessage("subscr_conf_note2") ?>
    </a>.
    </span>
    <input class="button" type="submit" name="confirm" value="<? echo GetMessage("subscr_conf_button") ?>"/>

    <input type="hidden" name="ID" value="<? echo $arResult["ID"]; ?>"/>
    <? echo bitrix_sessid_post(); ?>
</form>