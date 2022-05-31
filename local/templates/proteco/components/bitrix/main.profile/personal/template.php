<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();?>

    <h2 class="lk__content-h">Личные данные</h2>
    <?if (isset($_GET['edit_data']) || isset($_GET['edit_pass'])):?>
        <form class="personal-dat-edit" method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data" role="form">
            <?=$arResult["BX_SESSION_CHECK"]?>
            <input type="hidden" name="lang" value="<?=LANG?>" />
            <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
            <input type="hidden" name="SIGNED_DATA" value="<?=htmlspecialcharsbx($arResult["SIGNED_DATA"])?>" />
            <input type="hidden" name="LOGIN" value="<?=$arResult["arUser"]["LOGIN"]?>">
    <?endif;?>
    <?if (isset($_GET['edit_data'])):?>
            <input class="input" type="text" name="NAME" placeholder="<?=GetMessage('NAME_PL')?>" required value="<?=$arResult["arUser"]["NAME"]?>">
            <input class="input" type="text" name="WORK_COMPANY" placeholder="<?=GetMessage('WORK_COMPANY_PL')?>" required value="<?=$arResult["arUser"]["WORK_COMPANY"]?>">
            <input class="input" type="email" name="EMAIL" placeholder="<?=GetMessage('EMAIL_PL')?>" required value="<?=$arResult["arUser"]["EMAIL"]?>">
            <input class="input" type="tel" name="PERSONAL_PHONE" placeholder="<?=GetMessage('USER_PHONE_PL')?>" required value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>">
            <select class="input" name="WORK_PROFILE" required>
                <option value="" disabled hidden><?=GetMessage("WORK_PROFILE_PL")?></option>
                <?foreach ($GLOBALS['ORGANIZATION_TYPES'] as $orgType):?>
                    <option value="<?=$orgType['UF_NAME']?>"><?=$orgType['UF_NAME']?></option>
                <?endforeach;?>
            </select>
            <input class="button personal-dat-edit__button" type="submit" name="save"
                   value="<?=(($arResult["ID"]>0) ? GetMessage("SAVE") : GetMessage("MAIN_ADD"))?>">
        </form>
    <?elseif(isset($_GET['edit_pass']) && $arResult['CAN_EDIT_PASSWORD']):?>
            <input class="input" type="password" name="NEW_PASSWORD" placeholder="<?=GetMessage('NEW_PASSWORD_PL')?>" required autocomplete="off">
            <input class="input" type="password" name="NEW_PASSWORD_CONFIRM" placeholder="<?=GetMessage('NEW_PASSWORD_CONFIRM_PL')?>" required autocomplete="off">
            <input class="button personal-dat-edit__button" type="submit" name="save"
                   value="<?=(($arResult["ID"]>0) ? GetMessage("SAVE") : GetMessage("MAIN_ADD"))?>">
        </form>
    <?else:?>
        <ul class="personal-data">
            <li class="personal-data__item">
                <div class="personal-data__name"><?=GetMessage('NAME')?></div>
                <div class="personal-data__value"><?=$arResult["arUser"]["NAME"]?></div>
            </li>
            <li class="personal-data__item">
                <div class="personal-data__name"><?=GetMessage('USER_COMPANY')?></div>
                <div class="personal-data__value"><?=$arResult["arUser"]["WORK_COMPANY"]? : '-'?></div>
            </li>
            <li class="personal-data__item">
                <div class="personal-data__name"><?=GetMessage('EMAIL')?></div>
                <div class="personal-data__value"><?=$arResult["arUser"]["EMAIL"]?></div>
            </li>
            <li class="personal-data__item">
                <div class="personal-data__name"><?=GetMessage('USER_PHONE')?></div>
                <div class="personal-data__value"><?=$arResult["arUser"]["PERSONAL_PHONE"]?></div>
            </li>
            <li class="personal-data__item">
                <div class="personal-data__name"><?=GetMessage("USER_WORK_PROFILE")?></div>
                <div class="personal-data__value"><?=$arResult["arUser"]["WORK_PROFILE"] ? : '-'?></div>
            </li>
            <li class="personal-data__item">
                <div class="personal-data__name"><?=GetMessage("USER_PERSONAL_CITY")?></div>
                <div class="personal-data__value"><?=$arResult["arUser"]["PERSONAL_CITY"] ? : '-'?></div>
            </li>
        </ul>
        <div class="lk__content-button-wrap">
            <a class="button" href="?edit_data=Y">Изменить</a>
            <?if($arResult['CAN_EDIT_PASSWORD']):?>
                <a class="button button_ghost" href="?edit_pass=Y">Изменить пароль</a>
            <?endif;?>
        </div>
    <?endif;?>
    <?ShowError($arResult["strProfileError"]);?>
    <?
    if ($arResult['DATA_SAVED'] == 'Y')
        ShowNote(GetMessage('PROFILE_DATA_SAVED'));
    ?>
