<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if($USER->IsAuthorized() && intval($arParams["NEWS_IBLOCK_ID"]) > 0) {	
	//iblock elements
	$arSelectElems = array (
		"ID",
		"IBLOCK_ID",
		"NAME",
		"ACTIVE_FROM",
		"PROPERTY_" . $arParams["AUTHOR"]
	);
	$arFilterElems = array (
		"IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
		"ACTIVE" => "Y",
	);
	$arSortElems = array (
			"NAME" => "ASC"
	);
	
	$cur_user_news = array();
	$arResult["ELEMENTS"] = array();
	$rsElements = CIBlockElement::GetList($arSortElems, $arFilterElems, false, false, $arSelectElems);
	while($arElement = $rsElements->GetNext())
	{		
		if($arElement["PROPERTY_" . $arParams["AUTHOR"] . "_VALUE"] == $USER->GetID()) {
			$cur_user_news[] = $arElement["ID"];
		}
		
		$arResult["ELEMENTS"][$arElement["PROPERTY_" . $arParams["AUTHOR"] . "_VALUE"]][] = $arElement;
	}
	
	foreach($arResult["ELEMENTS"] as $author_id => $items)
	{
		foreach($items as $key => $item)
		{			
			if(in_array($item["ID"], $cur_user_news)) {
				unset($arResult["ELEMENTS"][$author_id][$key]);
			}
		}
	}
	
	// current user
	$rsUser = CUser::GetByID($USER->GetID());
	$arCurUser = $rsUser->Fetch();
		
	// user
	$arOrderUser = array("id");
	$sortOrder = "asc";
	$arFilterUser = array(
		"ACTIVE" => "Y",
		"!ID" => $USER->GetID(),
		$arParams["AUTHOR_TYPE"] => $arCurUser["UF_AUTHOR_TYPE"],
	);
	
	$arResult["USERS"] = array();
	$rsUsers = CUser::GetList($arOrderUser, $sortOrder, $arFilterUser); // выбираем пользователей
	while($arUser = $rsUsers->GetNext())
	{		
		foreach($arResult["ELEMENTS"] as $author_id => $item)
		{
			if($author_id == $arUser["ID"]) {
				$arUser["ITEMS"] = $item;
			}
		}
		
		$arResult["USERS"][] = $arUser;
	}
	
	unset($arResult["ELEMENTS"]);
}

$this->includeComponentTemplate();	
?>