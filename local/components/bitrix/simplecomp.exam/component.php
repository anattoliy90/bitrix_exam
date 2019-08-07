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
	$arResult = array();
	$count = 0;
	
	
	$rsSect = CIBlockSection::GetList(array(), array("IBLOCK_ID" => $arParams["CATALOG_IBLOCK_ID"], "ACTIVE"=>"Y", "!".$arParams["USER_PROPERTY"] => false), false, array("ID", "NAME", $arParams["USER_PROPERTY"]), false);
	while ($arSect = $rsSect->GetNext())
	{
		$arr_section[$arSect["ID"]] = $arSect;
	}
	
	$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $arParams["CATALOG_IBLOCK_ID"], "ACTIVE"=>"Y", "SECTION_ID" => array_keys($arr_section)), false, false, array("ID", "NAME", "PROPERTY_MATERIAL", "PROPERTY_ARTNUMBER", "PROPERTY_PRICE", "IBLOCK_SECTION_ID"));
	while($ob = $res->GetNext())
	{
		$arr_section[$ob["IBLOCK_SECTION_ID"]]["PRODUCTS"][] = $ob;
		
		$count++;
	}

	$rsIBlockElement = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"], "ACTIVE"=>"Y"), false, false, array("ID", "NAME", "DATE_ACTIVE_FROM"));
	while($obj = $rsIBlockElement->GetNext())
	{							
		foreach($arr_section as $section) {
			if(in_array($obj["ID"], $section["UF_NEWS_LINK"])) {
				$obj["ITEMS"][] = $section;
			}
		}
		
		$arResult[] = $obj;
	}
	
	$this->SetResultCacheKeys(array());
	$this->IncludeComponentTemplate();
}

$APPLICATION->SetTitle(GetMessage("ITEMS_COUNT") . $count);
?>
