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
?>
<?if (!empty($arResult["ITEMS"])):?>
    <section class="container-wrap training-centers__wrap">
        <div class="container-item training-centers">
            <h2 class="h1 training-centers__h">Наши учебные центры</h2>
            <ul class="training-centers__train-linc train-linc">
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                if ($arItem['PROPERTIES']['UF_ONLINE']['VALUE'] === 'Да') {
                    $class = 'train-linc__item_purple';
                    $arItem["NAME"] = $arItem['PROPERTIES']['UF_ONLINE_TITLE']['VALUE'];
                }
                $detailUrl = explode('/', $arItem['DETAIL_PAGE_URL']);
                ?>
                <li class="train-linc__item <?=$class?>" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                    <div class="train-linc__head">
                        <h3 class="train-linc__h"><?=$arItem["NAME"]?></h3>
                        <?if ($arItem['PROPERTIES']['UF_ADRES']['~VALUE']):?>
                            <div class="train-linc__adres">
                                <svg width="14" height="20">
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-point"></use>
                                </svg>
                                <span><?=$arItem['PROPERTIES']['UF_ADRES']['~VALUE']?></span>
                            </div>
                        <?endif;?>
                    </div>
                    <p class="train-linc__text">
                        <?=$arItem["~PREVIEW_TEXT"]?>
                    </p>
                    <a class="train-linc__linc" href="/<?=$detailUrl[1].'/'.$detailUrl[2]?>/">Подробнее
                        <svg width="14" height="8">
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-arrow"></use>
                        </svg>
                    </a>
                </li>
            <?endforeach;?>
            </ul>
        </div>
    </section>
<?endif;?>
