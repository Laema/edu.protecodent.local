<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use \Bitrix\Main\Localization\Loc;

$FORM_ID = trim($arParams['FORM_ID']);
$FORM_AUTOCOMPLETE = $arParams['FORM_AUTOCOMPLETE'] ? 'on' : 'off';
$FORM_ACTION_URI = "";
$WITH_FORM = strlen($arParams['WIDTH_FORM']) > 0 ? 'style="max-width:' . $arParams['WIDTH_FORM'] . '"' : '';
//pr($arParams);
//pr($arResult);
?>

<div class="popups__wrap" data-active-block="<?=$arParams['FORM_TYPE']?>">
    <div class="popups">
        <button class="popups__close" data-active-control="<?=$arParams['FORM_TYPE']?>">
            <svg width="15" height="15">
                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-cancel-button"></use>
            </svg>
        </button>
        <h3 class="popups__h"><?=$arParams['FORM_NAME']?></h3>
        <p class="popups__text"><?=$arParams['FORM_SUBTITLE']?></p>
        <form class="popups__input-wrap" id="<?= $FORM_ID ?>"
              enctype="multipart/form-data"
              method="POST"
              action="<?= ($FORM_ACTION_URI ? $FORM_ACTION_URI : "#") ?>"
              autocomplete="<?= $FORM_AUTOCOMPLETE ?>"
              novalidate="novalidate"
        >
            <!--<div class="alert alert-success <? /* if ($arResult['STATUS'] != 'ok'): */ ?>hidden<? /* endif; */ ?>" role="alert">
                <? /*= $arParams['OK_TEXT'] */ ?>
            </div>
            <div class="alert alert-danger <? /* if ($arResult['STATUS'] != 'error'): */ ?>hidden<? /* endif; */ ?>" role="alert">
                <? /*= $arParams['ERROR_TEXT'] */ ?>
                <? /* if (!empty($arResult['ERROR_MSG'])): */ ?>
                    </br>
                    <? /*= implode('</br>', $arResult['ERROR_MSG']) */ ?>
                <? /* endif; */ ?>
            </div>-->

            <input type="hidden" name="FORM_ID" value="<?= $FORM_ID ?>">
            <input type="text" name="ANTIBOT[NAME]" style="display: none" value="<?= $arResult['ANTIBOT']['NAME']; ?>">

            <? //hidden fields
            foreach ($arResult['FORM_FIELDS'] as $fieldCode => $arField) {
                if ($arField['TYPE'] == 'hidden') {
                    ?>
                    <input type="hidden" name="<?= $arField['NAME'] ?>" value="<?= $arField['VALUE']; ?>"/>
                    <?
                    unset($arResult['FORM_FIELDS'][$fieldCode]);
                }
            }
            if (!empty($arResult['FORM_FIELDS'])):
                foreach ($arResult['FORM_FIELDS'] as $fieldCode => $arField):

                    if (!$arParams['HIDE_ASTERISK'] && !$arParams['HIDE_FIELD_NAME']) {
                        $asteriks = ':';
                        if ($arField['REQUIRED']) {
                            $asteriks = '<span class="asterisk">*</span>:';
                        }
                        $arField['TITLE'] = $arField['TITLE'] . $asteriks;
                    }

                    if ($arField['TYPE'] == 'textarea'):?>
                        <textarea class="input" id="<?= $arField['ID'] ?>"
                                  name="<?= $arField['NAME'] ?>" <?= $arField['PLACEHOLDER_STR']; ?> <?= $arField['REQ_STR'] ?>>
                            <?= $arField['VALUE']; ?>
                        </textarea>
                    <? elseif ($arField['TYPE'] == 'radio' || $arField['TYPE'] == 'checkbox'): ?>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <? if (!$arParams['HIDE_FIELD_NAME']): ?>
                                    <label class="control-label"><?= $arField['TITLE'] ?>&nbsp;</label>
                                <? endif; ?>
                                <? foreach ($arField['VALUE'] as $key => $arVal): ?>
                                    <? if (!$arField['SHOW_INLINE']): ?><div class="<?= $arField['TYPE'] ?>"><? endif; ?>
                                    <? if (!empty($arVal)): ?>
                                        <label class="<?= $arField['SHOW_INLINE'] ? $arField['TYPE'] . '-inline' : '' ?>">
                                            <input type="<?= $arField['TYPE'] ?>" name="<?= $arField['NAME'] ?>"
                                                   value="<?= $arVal ?>" <?= $arField['REQ_STR'] ?>>&nbsp;<?= $arVal ?>
                                        </label>
                                    <? endif; ?>
                                    <? if (!$arField['SHOW_INLINE']): ?></div><? endif; ?>
                                <? endforeach; ?>
                            </div>
                        </div>
                    <? elseif ($arField['TYPE'] == 'accept'): ?>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="<?= $arField['NAME'] ?>"
                                           value="<?= Loc::getMessage('SLAM_EASYFORM_YES') ?>" <?= $arField['REQ_STR'] ?>>&nbsp;<?= htmlspecialcharsBack($arField['VALUE']) ?>
                                </label>
                            </div>
                        </div>
                    <? elseif ($arField['TYPE'] == 'select'): ?>
                        <select class="input" id="<?= $arField['ID'] ?>"
                                <?= $arField['MULTISELECT'] == 'Y' ? 'multiple' : '' ?>
                                name="<?= $arField['NAME'] ?>" <?= $arField['REQ_STR'] ?>>
                            <option value="" disabled selected hidden>?????? ??????????????????????*</option>
                            <?foreach ($GLOBALS['ORGANIZATION_TYPES'] as $orgType):?>
                                <option value="<?=$orgType['UF_NAME']?>"><?=$orgType['UF_NAME']?></option>
                            <?endforeach;?>
                        </select>
                    <? elseif ($arField['TYPE'] == 'select_email'): ?>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <? if (!$arParams['HIDE_FIELD_NAME']): ?>
                                    <label for="<?= $arField['ID'] ?>"
                                           class="control-label"><?= $arField['TITLE'] ?></label>
                                <? endif; ?>
                                <select class="form-control" id="<?= $arField['ID'] ?>"
                                        name="<?= $arField['NAME'] ?>" <?= $arField['REQ_STR'] ?>>
                                    <option value="">&#8212;</option>
                                    <? if (is_array($arField['VALUE'])): ?>
                                        <? foreach ($arField['VALUE'] as $arVal): ?>
                                            <? if (!empty($arVal)): ?>
                                                <option value="<?= $arVal ?>"><?= $arVal ?></option>
                                            <? endif; ?>
                                        <? endforeach; ?>
                                    <? endif; ?>
                                </select>
                            </div>
                        </div>
                    <? elseif ($arField['TYPE'] == 'file'): ?>
                        <? $CID = $GLOBALS["APPLICATION"]->IncludeComponent(
                            'bitrix:main.file.input',
                            $arField['DROPZONE_INCLUDE'] ? 'drag_n_drop' : '.default',
                            array(
                                'HIDE_FIELD_NAME' => $arParams['HIDE_FIELD_NAME'],
                                'INPUT_NAME' => $arField['CODE'],
                                'INPUT_TITLE' => $arField['TITLE'],
                                'INPUT_NAME_UNSAVED' => $arField['CODE'],
                                'MAX_FILE_SIZE' => $arField['FILE_MAX_SIZE'],//'20971520', //20Mb
                                'MULTIPLE' => 'Y',
                                'CONTROL_ID' => $arField['ID'],
                                'MODULE_ID' => 'slam.easyform',
                                'ALLOW_UPLOAD' => 'F',
                                'ALLOW_UPLOAD_EXT' => $arField['FILE_EXTENSION'],
                            ),
                            $component,
                            array("HIDE_ICONS" => "Y")
                        ); ?>
                    <? else: ?>
                        <input class="input" id="<?= $arField['ID'] ?>"
                               type="<?= $arField['TYPE']; ?>"
                               name="<?= $arField['NAME'] ?>" <?= $arField['PLACEHOLDER_STR']; ?>
                               value="<?= $arField['VALUE']; ?>"
                            <?= $arField['REQ_STR'] ?>>
                    <?endif;
                endforeach; ?>
                <? if ($arParams["USE_CAPTCHA"]): ?>
                <div class="col-xs-12">
                    <div class="form-group">
                        <? if (!$arParams['HIDE_FIELD_NAME'] && strlen($arParams['CAPTCHA_TITLE']) > 0): ?>
                            <label for="<?= $FORM_ID ?>-captchaValidator"
                                   class="control-label"><?= htmlspecialcharsBack($arParams['CAPTCHA_TITLE']) ?></label>
                        <? endif; ?>
                        <input id="<?= $FORM_ID ?>-captchaValidator" class="form-control" type="text" required
                               data-bv-notempty-message="<?= GetMessage("SLAM_REQUIRED_MESS"); ?>"
                               name="captchaValidator"
                               style="border: none; height: 0; padding: 0; visibility: hidden;">
                        <div id="<?= $FORM_ID ?>-captchaContainer"></div>
                    </div>
                </div>
            <? endif; ?>

                <p class="popups__user-agreement">
                    ?????????????? ???? ????????????, ?? ??????????????????????, ?????? ???????????????? ???? ?????????????????? ???????? ???????????????????????? ????????????, ?? ?????????? ?? <a target="_blank" href="<?=$GLOBALS['OPTIONS']['UF_AGREEMENT_URL']['VALUE']?>">???????????????????????????????? ??????????????????????</a>
                </p>
                <button type="submit" class="button popups__button"
                        data-default="<?= $arParams['FORM_SUBMIT_VALUE'] ?>"><?= $arParams['FORM_SUBMIT_VALUE'] ?></button>
            <? endif; ?>
        </form>

        <? if ($arParams['SHOW_MODAL'] == 'Y'): ?>
            <div class="modal fade modal-add-holiday" id="frm-modal-<?= $FORM_ID ?>" role='dialog' aria-hidden='true'>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header clearfix">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&#10006;
                            </button>

                            <? if ($arParams['TITLE_SHOW_MODAL'] || $arParams['FORM_NAME']): ?>
                                <div class="title"><?= $arParams['TITLE_SHOW_MODAL'] ?: $arParams['FORM_NAME'] ?></div>
                            <? endif ?>

                        </div>
                        <div class="modal-body">
                            <p class="ok-text"><?= $arParams['OK_TEXT'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <? endif; ?>
    </div>
    <div class="popups__close-area" data-active-control="<?=$arParams['FORM_TYPE']?>"></div>
</div>

<script type="text/javascript">
    var easyForm = new JCJsEasyForm(<?echo CUtil::PhpToJSObject($arParams)?>);
</script>
