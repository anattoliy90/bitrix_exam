<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;
	
$arParams["CATALOG_IBLOCK_ID"] = (int) $arParams["CATALOG_IBLOCK_ID"];
$arParams["NEWS_IBLOCK_ID"] = (int) $arParams["NEWS_IBLOCK_ID"];

if($arParams["CATALOG_IBLOCK_ID"] > 0 && $arParams["NEWS_IBLOCK_ID"] > 0 && $this->StartResultCache())
{
	if(!CModule::IncludeModule("iblock"))
	{
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	
	$arr_section = array();
	$arr_items = array();
	$arResult["ITEMS"] = array();
	$arResult["COUNT"] = 0;
	$arr_prices = array();
	
	
	$rsSect = CIBlockSection::GetList(array(), array("IBLOCK_ID" => $arParams["CATALOG_IBLOCK_ID"], "ACTIVE"=>"Y", "!".$arParams["USER_PROPERTY"] => false), false, array("ID", "NAME", $arParams["USER_PROPERTY"]), false);
	while ($arSect = $rsSect->GetNext())
	{
		$arr_section[$arSect["ID"]] = $arSect;
	}
	
	$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $arParams["CATALOG_IBLOCK_ID"], "ACTIVE"=>"Y", "SECTION_ID" => array_keys($arr_section)), false, false, array("ID", "NAME", "PROPERTY_MATERIAL", "PROPERTY_ARTNUMBER", "PROPERTY_PRICE", "IBLOCK_SECTION_ID"));
	while($ob = $res->GetNext())
	{		
		$arr_section[$ob["IBLOCK_SECTION_ID"]]["PRODUCTS"][] = $ob;
		
		$arr_items[] = $ob["ID"];
		
		$arr_prices[] = $ob["PROPERTY_PRICE_VALUE"];
	}
	
	$arResult["COUNT"] = count($arr_items);
	
	$arResult["MIN_PRICE"] = min($arr_prices);
	$arResult["MAX_PRICE"] = max($arr_prices);

	$rsIBlockElement = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"], "ACTIVE"=>"Y"), false, false, array("ID", "NAME", "DATE_ACTIVE_FROM"));
	while($obj = $rsIBlockElement->GetNext())
	{							
		foreach($arr_section as $section) {
			if(in_array($obj["ID"], $section[$arParams["USER_PROPERTY"]])) {
				$obj["ITEMS"][] = $section;
			}
		}
		
		$arResult["ITEMS"][] = $obj;
	}
	
	$this->SetResultCacheKeys(array(
		"COUNT",
		"MIN_PRICE",
		"MAX_PRICE",
	));
	
	$this->IncludeComponentTemplate();
}

$APPLICATION->SetTitle(GetMessage("ITEMS_COUNT") . $arResult["COUNT"]);

$APPLICATION->AddViewContent('catalog_min_price', GetMessage('MIN_PRICE') . " " . $arResult["MIN_PRICE"]);
$APPLICATION->AddViewContent('catalog_max_price', GetMessage('MAX_PRICE') . " " . $arResult["MAX_PRICE"]);
