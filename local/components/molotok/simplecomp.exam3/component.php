<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 3600;

$arParams["CATALOG_IBLOCK"] = intval($arParams["CATALOG_IBLOCK"]);
$arParams["CLASSIFIER_IBLOCK"] = intval($arParams["CLASSIFIER_IBLOCK"]);

if(isset($_REQUEST["F"])) {
	$this->ClearResultCache($USER->GetGroups());
}

$arNavParams = false;

if(!empty($arParams["ITEMS_ON_PAGE"])) {
	$arNavParams = array("nPageSize" => $arParams["ITEMS_ON_PAGE"]);
	$arNavigation = CDBResult::GetNavParams($arNavParams);
}

if($this->StartResultCache(false, array($USER->GetGroups(), $arNavigation))) {
	if(!CModule::IncludeModule("iblock")) {
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	
	$arr_items = array();
	$arr_firm = array();
	$arr_count = array();
	$arResult["COUNT"] = 0;
	$arrFilter = array("IBLOCK_ID" => $arParams["CATALOG_IBLOCK"], "ACTIVE" => "Y", "CHECK_PERMISSIONS" => "Y");
	
	if(isset($_REQUEST["F"])) {
		$this->AbortResultCache();
		
		$arrFilter_ext = array(array(
			"LOGIC" => "OR",
			array("<=PROPERTY_PRICE" => 1700, "PROPERTY_MATERIAL" => "Дерево, ткань"),
			array("<PROPERTY_PRICE" => 1500, "PROPERTY_MATERIAL" => "Металл, пластик"),
		));
		
		$arrFilter = array_merge($arrFilter, $arrFilter_ext);
	}
	
	$res = CIBlockElement::GetList(array("NAME" => "ASC", "SORT" => "ASC"), $arrFilter, false, false, array("ID", "NAME", "IBLOCK_SECTION_ID", "PROPERTY_PRICE", "PROPERTY_MATERIAL", "PROPERTY_ARTNUMBER", "PROPERTY_" . $arParams["PROP_CODE"], "DETAIL_PAGE_URL"));	
	$res->SetUrlTemplates($arParams["DETAIL_URL_TEMPLATE"]);
	while($ob = $res->GetNext())
	{
		$arButtons = CIBlock::GetPanelButtons(
			$ob["IBLOCK_ID"],
			$ob["ID"],
			0,
			array("SECTION_BUTTONS" => false, "SESSID" => false)
		);
		
		$ob["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
		$ob["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];
		
		if(!empty($ob["PROPERTY_FIRM_VALUE"])) {
			$arr_items[$ob["PROPERTY_FIRM_VALUE"]][] = $ob;
			
			if(!in_array($ob["ID"], $arr_count)) {
				$arr_count[] = $ob["ID"];
			}
		}
	}

	$arResult["ID"] = $arParams["CATALOG_IBLOCK"];
	
	if($USER->IsAuthorized()) {
		if($APPLICATION->GetShowIncludeAreas()) {
			if(CModule::IncludeModule("iblock")) {
				$arButtons = CIBlock::GetPanelButtons(
					$arResult["ID"],
					0,
					$arParams["PARENT_SECTION"],
					array("SECTION_BUTTONS" => false)
				);

				if($APPLICATION->GetShowIncludeAreas())
					$this->AddIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));
			}
		}
	}
	
	$arResult["COUNT"] = count($arr_count);
	
	$result = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $arParams["CLASSIFIER_IBLOCK"], "ID" => array_keys($arr_items), "CHECK_PERMISSIONS" => "Y"), false, $arNavParams, array("ID", "NAME"));
	while($obj = $result->GetNext())
	{
		if(array_key_exists($obj["ID"], $arr_items)) {
			$arr_firm[$obj["NAME"]] = $arr_items[$obj["ID"]];
		}
	}
	
	if(!empty($arr_firm)) {
		$arResult["ITEMS"] = $arr_firm;
	}
	
	$arResult["NAV_STRING"] = $result->GetPageNavStringEx(
		$navComponentObject,
		GetMessage("NAVIGATION"),
		".default"
	);
	
	$this->SetResultCacheKeys(array(
		"COUNT"
	));
	$this->IncludeComponentTemplate();
}

$APPLICATION->SetTitle(GetMessage("ITEMS_COUNT") . "[" . $arResult["COUNT"] . "]");
