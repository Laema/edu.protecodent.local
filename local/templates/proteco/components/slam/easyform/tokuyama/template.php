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
<section class="container-wrap t-dental-form-page__wrap" id="join_klub">
    <div class="container-item t-dental-form-page">
        <div class="t-dental-form">
            <div class="t-dental-form__img">
                <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/form-img1.jpg">
            </div>
            <div class="t-dental-form__body">
                <h3 class="popups__h"><?= $arParams['FORM_NAME'] ?></h3>
                <form class="t-dental-form__form" id="<?= $FORM_ID ?>"
                      enctype="multipart/form-data"
                      method="POST"
                      action="<?= ($FORM_ACTION_URI ? $FORM_ACTION_URI : "#") ?>"
                      autocomplete="<?= $FORM_AUTOCOMPLETE ?>"
                      novalidate="novalidate"
                >
                    <input type="hidden" name="FORM_ID" value="<?= $FORM_ID ?>">
                    <input type="text" name="ANTIBOT[NAME]" style="display: none"
                           value="<?= $arResult['ANTIBOT']['NAME']; ?>">

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
                                    $asteriks = '*';
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
                                    <option value="" disabled selected hidden>Тип организации*</option>
                                    <? foreach ($GLOBALS['ORGANIZATION_TYPES'] as $orgType): ?>
                                        <option value="<?= $orgType['UF_NAME'] ?>"><?= $orgType['UF_NAME'] ?></option>
                                    <? endforeach; ?>
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
                                <input class="input<?if ($arField['NAME'] !== 'FIELDS[COMPANY_NAME]'):?> t-dental-form__form-item_05<?endif;?>" id="<?= $arField['ID'] ?>"
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
                            Нажимая на кнопку, я подтверждаю, что согласен на обработку моих персональных данных, а также с <a target="_blank" href="<?=$GLOBALS['OPTIONS']['UF_AGREEMENT_URL']['VALUE']?>">Пользовательским соглашением</a>
                        </p>
                        <button type="submit" class="button t-dental-form__form-button"
                                data-default="<?= $arParams['FORM_SUBMIT_VALUE'] ?>"><?= $arParams['FORM_SUBMIT_VALUE'] ?></button>
                    <? endif; ?>
                </form>

                <? if ($arParams['SHOW_MODAL'] == 'Y'): ?>
                    <div class="modal fade modal-add-holiday" id="frm-modal-<?= $FORM_ID ?>" role='dialog'
                         aria-hidden='true'>
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
        </div>
    </div>
</section>

<script type="text/javascript">
    var easyForm = new JCJsEasyForm(<?echo CUtil::PhpToJSObject($arParams)?>);
</script>