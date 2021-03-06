<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<? if (!empty($arResult["ITEMS"])): ?>
    <section class="container-wrap podcast-page__podcast-list-wrap">
        <div class="container-item podcast-list">
            <h1 class="h1 podcast-list__h">Вам может понравиться:</h1>
            <ul class="event-page__video-list similar-list">
                <? foreach ($arResult["ITEMS"] as $arItem): ?>
                    <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <li class="video-main__item" data-entity="item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                        <a class="video-main__linc" href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                            <div class="video-main__linc-body">
                                <div class="video-main__linc-play">
                                    <svg width="22" height="22">
                                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-button-play"></use>
                                    </svg>
                                </div>
                                <img class="video-main__linc-img"
                                     src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?: '/local/templates/proteco/assets/images/img1.jpg' ?>"
                                     width="<?= $arItem["PREVIEW_PICTURE"]["WIDTH"] ?>"
                                     height="<?= $arItem["PREVIEW_PICTURE"]["HEIGHT"] ?>"
                                     alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                     title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                                >
                            </div>
                            <div class="video-main__linc-bot">
                                <p class="video-main__linc-text"><?= $arItem["NAME"] ?></p>
                                <span class="button video-main__linc-button">Смотреть</span>
                            </div>
                        </a>
                    </li>
                <? endforeach; ?>
            </ul>
        </div>
    </section>
<? endif; ?>