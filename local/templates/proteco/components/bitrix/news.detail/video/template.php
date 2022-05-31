<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$props = $arResult['PROPERTIES'];
?>
<section class="container-wrap podcast-page__wrap">
    <div class="container-item podcast-page">
        <h1 class="podcast-pag__h"><?=$arResult["NAME"]?></h1>
        <?if ($arResult['SECTION']['PATH'][0]['ID'] === '15'):?>
            <?if ($props['UF_VIDEO_FILE']['VALUE']):?>
                <div class="podcast-pag__audio-player audio-player">
                    <audio src="<?=CFile::GetPath($props['UF_VIDEO_FILE']['VALUE'])?>" controls></audio>
                    <div class="audio-player__progres_wrap">
                        <div class="audio-player__progres">
                            <input type="range" name="progres" value="0" min="0" max="100" step="1">
                            <div class="audio-player__progres-mimic"></div>
                        </div>
                        <div class="audio-player__time-wrap">
                            <div class="audio-player__time-now">0:00</div>
                            <div class="audio-player__time-end">0:00</div>
                        </div>
                    </div>
                    <div class="audio-player__control-wrap">
                        <button class="audio-player__rewind audio-player__rewind_back">
                            <div class="audio-player__rewind-text">30</div>
                            <svg class="audio-player__rewind-icon" width="32" height="32">
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-button-rewind"></use>
                            </svg>
                        </button>
                        <button class="audio-player__play-pause" data-player-play="false">
                            <svg class="audio-player__icon-play" width="16" height="16">
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-button-play"></use>
                            </svg>
                            <svg class="audio-player__icon-pause" width="16" height="16">
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-button-pause"></use>
                            </svg>
                        </button>
                        <button class="audio-player__rewind audio-player__rewind_forward">
                            <div class="audio-player__rewind-text">30</div>
                            <svg class="audio-player__rewind-icon" width="32" height="32">
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-button-rewind"></use>
                            </svg>
                        </button>
                        <label class="audio-player__volume">
                            <div class="audio-player__volume-progres">
                                <div class="audio-player__progres">
                                    <input type="range" name="volume" value="1" min="0" max="1" step="0.01">
                                    <div class="audio-player__progres-mimic"></div>
                                </div>
                            </div>
                            <button class="audio-player__volume-button">
                                <svg width="21" height="20">
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-volume"></use>
                                </svg>
                            </button>
                        </label>
                    </div>
                </div>
            <?endif;?>
        <?else:?>
            <?if ($props['UF_VIDEO_YT']['VALUE']):?>
                <div class="podcast-pag__audio-player video-player">
                     <iframe width="100%" height="430" src="https://www.youtube.com/embed/<?=$props['UF_VIDEO_YT']['VALUE']?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <!-- <iframe width="770" height="430" src="https://www.youtube.com/embed/<?//=explode('&', explode('=', parse_url($props['UF_VIDEO_YT']['VALUE'], PHP_URL_QUERY))[1])[0]?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
                </div>
            <?endif;?>
        <?endif;?>
        <?
        if(!empty($props['UF_SPIKER']['VALUE'])) {
            $arFilter = Array("IBLOCK_ID"=>1, "ID" => $props['UF_SPIKER']['VALUE'], "ACTIVE"=>"Y");
            $speakerOb = CIBlockElement::GetList(Array(), $arFilter, false, Array(), Array());
            if ($speaker = $speakerOb->GetNext()) :?>
                <h2 class="podcast-pag__h">Спикер</h2>
                <div class="podcast-page__person">
                    <img class="podcast-page__person-img" src="<?=CFile::GetPath($speaker['PREVIEW_PICTURE'])?>" alt="<?=$speaker['NAME']?>">
                    <div class="podcast-page__person-wrap">
                        <div class="podcast-page__person-name"><?= $speaker["NAME"] ?></div>
                        <div class="podcast-page__person-post"><?=$speaker['~PREVIEW_TEXT']?></div>
                        <?if ($arResult['HAVE_EVENTS']):?>
                            <a class="speakers-page__item-linc" target="_blank" href="/events/?filterSPEAKER=<?=$arResult['DISPLAY_PROPERTIES']['UF_SPIKER']['VALUE']?>">
                                Мероприятия спикера
                                <svg width="14" height="8">
                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-arrow"></use>
                                </svg>
                            </a>
                        <?endif;?>
                        <?if ($arResult['HAVE_MATERIALS']):?>
                            <a class="speakers-page__item-linc" target="_blank" href="/materialy/?SPEAKER=<?=$arResult['DISPLAY_PROPERTIES']['UF_SPIKER']['VALUE']?>">
                                Материалы спикера
                                <svg width="14" height="8">
                                    <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-arrow"></use>
                                </svg>
                            </a>
                        <?endif;?>
                    </div>
                </div>
            <?endif;
        }?>
        <?if ($arResult['~DETAIL_TEXT']):?>
            <h2 class="podcast-pag__h">Описание</h2>
            <?=$arResult['~DETAIL_TEXT']?>
        <?endif;?>
        <?if ($props['UF_POINTS']['VALUE']):?>
            <?if ($arResult['SECTION']['PATH'][0]['ID'] === '15'):?>
                <div class="podcast-pag__h">За прослушивание аудиоподкаста начисляется <?=declOfNum($props['UF_POINTS']['VALUE'], ['балл', 'балла', 'баллов'])?> </div>
            <?else:?>
                <div class="podcast-pag__h">За просмотр видео начисляется <?=declOfNum($props['UF_POINTS']['VALUE'], ['балл', 'балла', 'баллов'])?> </div>
            <?endif;?>
        <?endif;?>
        <a class="linc-arrow podcast-pag__beck" href="<?=$arResult['SECTION_URL']?>">
            <svg width="14" height="8">
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
            </svg>
            <span>Вернуться назад</span>
        </a>
    </div>
</section>
<?
if ($arResult['SECTION']['PATH'][0]['ID'] === '15') {
    $similarTemplate = "similar_audio";
} else {
    $similarTemplate = "similar_video";
}
//$GLOBALS['similarFilter']['!ID'] = $arResult['ID'];
//$GLOBALS['similarFilter']['SECTION_ID'] = $arResult['IBLOCK_SECTION_ID'];

$GLOBALS['similarFilter']['ID'] = $arResult['PROPERTIES']['UF_POPULAR']['VALUE'];
?>
<?php if ($arResult['PROPERTIES']['UF_POPULAR']['VALUE']) :?>
<? $APPLICATION->IncludeComponent(
    "bitrix:news.list",
    $similarTemplate,
    array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "N",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array("", ""),
        "FILE_404" => "",
        "FILTER_NAME" => "similarFilter",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => "6",
        "IBLOCK_TYPE" => "content",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "Y",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "4",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Новости",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array("UF_FILE_LONG", ""),
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "Y",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_BY2" => "SORT",
        "SORT_ORDER1" => "DESC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N"
    )
); ?>
<?php endif?>
