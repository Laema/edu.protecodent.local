<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';

$strReturn .= '<div class="container-item">
                <div class="breadcrumbs" itemprop="http://schema.org/breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '
			<a class="breadcrumbs__item" id="bx_breadcrumb_'.$index.'" href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="item">
				<span itemprop="name">'.$title.'</span>
				<svg width="14" height="8"><use xlink:href="'.SITE_TEMPLATE_PATH.'/assets/images/sprite.svg#icon-arrow"></use></svg>
				<meta itemprop="position" content="'.($index + 1).'" />
			</a>';
	}
	else
	{
		$strReturn .= '
			<div class="breadcrumbs__item">
			    <span>'.$title.'</span>
				<svg width="14" height="8"><use xlink:href="'.SITE_TEMPLATE_PATH.'/assets/images/sprite.svg#icon-arrow"></use></svg>
			</div>';
	}
}

$strReturn .= '</div></div>';

return $strReturn;
