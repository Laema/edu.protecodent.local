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
<section class="container-wrap t-dental__wrap" id="about_klub">
    <div class="container-item t-dental">
        <h1 class="t-dental__h"><? $APPLICATION->showTitle(false) ?></h1>
        <img class="t-dental__img" src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>"
             alt="<?= $arResult["DETAIL_PICTURE"]["ALT"] ?>"
             title="<?= $arResult["DETAIL_PICTURE"]["TITLE"] ?>">
        <div class="t-dental__text">
            <?= $arResult["~DETAIL_TEXT"] ?>
        </div>
        <? if (!empty($arResult['DISPLAY_PROPERTIES']['UF_GALERY']['FILE_VALUE'])): ?>
            <div class="reviews-slider__wrap">
                <div class="swiper-container slider_nav t-dental__slider">
                    <div class="swiper-wrapper" data-list-gallery>
                        <? foreach ($arResult['DISPLAY_PROPERTIES']['UF_GALERY']['FILE_VALUE'] as $img): ?>
                            <div class="swiper-slide">
                                <a class="slider_nav__img" href="<?= $img['SRC'] ?>"
                                   data-img-gallery data-sub-html="&lt;p&gt;<?= $img['DESCRIPTION'] ?>&lt;/p&gt;">
                                    <img src="<?= $img['SRC'] ?>" alt="<?= $img['DESCRIPTION'] ?>">
                                </a>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
                <div class="slider_nav__el"></div>
                <div class="reviews-slider__prev">
                    <svg width="14" height="8">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-arrow"></use>
                    </svg>
                </div>
                <div class="reviews-slider__next">
                    <svg width="14" height="8">
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/images/sprite.svg#icon-arrow"></use>
                    </svg>
                </div>
            </div>
        <? endif; ?>
    </div>
</section>