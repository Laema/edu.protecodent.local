<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>
    <nav class="burger-menu-nav">
        <? foreach ($arResult as $key => $arItem): ?>
            <div class="burger-menu-nav__item">
                <div class="burger-menu-nav__head">
                    <a class="burger-menu-nav__head-linc" href="<?= $arItem['LINK'] ?>"><?= $arItem['TEXT'] ?></a>
                    <? if (!empty($arItem['ITEMS'])): ?>
                        <button class="burger-menu-nav__head-button" data-collapse-control="menu<?= $key ?>"
                                data-collapse="true">
                            <svg width="14" height="8">
                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-arrow"></use>
                            </svg>
                        </button>
                    <? endif; ?>
                </div>
                <? if (!empty($arItem['ITEMS'])): ?>
                    <ul class="burger-menu-nav__list" data-collapse-block="menu<?= $key ?>">
                        <? foreach ($arItem['ITEMS'] as $child): ?>
                            <li class="burger-menu-nav__list-item">
                                <a class="burger-menu-nav__list-linc"
                                   href="<?= $child['LINK'] ?>"><?= $child['TEXT'] ?></a>
                            </li>
                        <? endforeach ?>
                    </ul>
                <? endif; ?>
            </div>
        <? endforeach ?>
    </nav>
<? endif ?>