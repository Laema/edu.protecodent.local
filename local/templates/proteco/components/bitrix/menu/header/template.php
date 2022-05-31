<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<nav class="header__main-menu">
    <ul class="main-menu">
        <li class="main-menu__item-button">
            <button class="header__burger-button" data-active-control="burger1">
                <div class="header__burger-button-icon"></div>
                <span class="main-menu__linc">Меню</span>
            </button>
        </li>
        <?if (!empty($arResult)):?>
            <? foreach($arResult as $arItem):
                if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                    continue; ?>
                <?if($arItem["SELECTED"]):?>
                    <li class="main-menu__item"><a class="main-menu__linc" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                <?else:?>
                    <li class="main-menu__item"><a class="main-menu__linc" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                <?endif?>
            <?endforeach?>
        <?endif?>
    </ul>
</nav>
