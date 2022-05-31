<? if (isset($GLOBALS['USER_ORDERS']) && !empty($GLOBALS['USER_ORDERS']['EVENTS_ID'])): ?>
    <?
    $arSelect = array("ID", "NAME",
        "PROPERTY_UF_VIDEO_YOUTUBE",
    );
    $arFilter = array(
        "IBLOCK_ID" => 3,
        "ID" => $GLOBALS['USER_ORDERS']['EVENTS_ID'],
        "ACTIVE" => "Y",
        ">=PROPERTY_UF_TIME_AFT" => date("Y-m-d H:i:s"),
        "<=PROPERTY_UF_TIME_BEF" => date("Y-m-d H:i:s")
    );
    $onlineEvOb = CIBlockElement::GetList(array("PROPERTY_UF_TIME_BEF" => "ASC"), $arFilter, false, array(), $arSelect);
    $onlineEvArr = $onlineEvOb->GetNext();
    if (!(isset($_COOKIE['closeId']) and $_COOKIE['closeId'] == $onlineEvArr['ID']) and $onlineEvArr):?>
        <div class="container-wrap header-event__wrap active" data-active-block="header1">
            <div class="container-item header-event">
                <button class="header-event__close" onclick="setDataToCookie(this)" data-active-control="header1" data-id-event="<?=$onlineEvArr['ID']?>">
                    <svg width="15" height="15">
                        <use xlink:href="/local/templates/proteco/assets/images/sprite.svg#icon-cancel-button"></use>
                    </svg>
                </button>
                <div class="header-event__text-wrap">
                    <div class="header-event__heading">Началась трансляция</div>
                    <div class="header-event__text"><?= $onlineEvArr['NAME'] ?></div>
                </div>
                <? if ($onlineEvArr['PROPERTY_UF_VIDEO_YOUTUBE_VALUE']):?>
                    <a class="button button_wheat header-event__button"
                       href="<?= $onlineEvArr['PROPERTY_UF_VIDEO_YOUTUBE_VALUE'] ?>">
                        <svg width="10" height="10">
                            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-button-play"></use>
                        </svg>
                        <span>Присоединиться</span>
                    </a>
                <? endif; ?>
            </div>
        </div>
        <script>
            function setDataToCookie(elem) {
                document.cookie = "closeId=" + elem.getAttribute('data-id-event');
            }
        </script>
    <? endif; ?>
    <?
    unset($arSelect);
    unset($arFilter);
    unset($onlineEvOb);
    ?>
<? endif; ?>