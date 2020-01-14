<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 3600;

$arParams["CATALOG_IBLOCK"] = intval($arParams["CATALOG_IBLOCK"]);
$arParams["CLASSIFIER_IBLOCK"] = intval($arParams["CLASSIFIER_IBLOCK"]);

if($this->StartResultCache(false, ($arParams["CACHE_GROUPS"]==="N" ? false : $USER->GetGroups()))) {
	if(!CModule::IncludeModule("iblock")) {
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	
	$arr_items = array();
	$arr_firm = array();
	
	$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $arParams["CATALOG_IBLOCK"], "ACTIVE" => "Y"), false, false, array("ID", "NAME", "IBLOCK_SECTION_ID", "PROPERTY_PRICE", "PROPERTY_MATERIAL", "PROPERTY_ARTNUMBER", "PROPERTY_" . $arParams["PROP_CODE"]));
	while($ob = $res->GetNext())
	{
		if(!empty($ob["PROPERTY_FIRM_VALUE"])) {
			$arr_items[$ob["PROPERTY_FIRM_VALUE"]][] = $ob;
		}
	}
	
	$result = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $arParams["CLASSIFIER_IBLOCK"], "ID" => array_keys($arr_items)), false, false, array("ID", "NAME"));
	while($obj = $result->GetNext())
	{	
		if(array_key_exists($obj["ID"], $arr_items)) {
			$arr_firm[$obj["NAME"]] = $arr_items[$obj["ID"]];
		}
	}
	
	if(!empty($arr_firm)) {
		$arResult["ITEMS"] = $arr_firm;
	}
	
	$this->SetResultCacheKeys(array());
	$this->IncludeComponentTemplate();
}
