<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>
    <nav class="lk__nav">
        <button class="lk__nav-collapse-controll collapse-on-768" data-collapse-control="lk1" data-collapse="true" data-collapse-name=".active &gt; a">
            <svg width="14" height="8">
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
            </svg>
        </button>
        <ul class="lk__nav-list" data-collapse-block="lk1">
        <?
        foreach ($arResult as $arItem):
            if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                continue;
            ?>
            <li class="lk__nav-item<? if ($arItem["SELECTED"]):?> active<? endif ?>">
                <a class="lk__nav-linc" href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
            </li>
        <? endforeach ?>
        </ul>
        <a class="lk__nav-logout" href="<?="?logout=yes&sessid=".$_SESSION["fixed_session_id"]?>">Выйти из личного кабинета</a>
    </nav>
<? endif ?>