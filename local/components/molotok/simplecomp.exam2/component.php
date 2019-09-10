<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	$this->AbortResultCache();
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 3600000;

if($USER->IsAuthorized() && intval($arParams["NEWS_IBLOCK_ID"]) > 0 && $this->StartResultCache(false, $USER->GetID())) {
	// current user
	$rsUser = CUser::GetByID($USER->GetID());
	$arCurUser = $rsUser->Fetch();
		
	// user
	$arOrderUser = array("id");
	$sortOrder = "asc";
	$arFilterUser = array(
		"ACTIVE" => "Y",
		$arParams["AUTHOR_TYPE"] => $arCurUser["UF_AUTHOR_TYPE"],
	);
	
	$arResult["USERS"] = array();
	$users_ids = array();
	
	$rsUsers = CUser::GetList($arOrderUser, $sortOrder, $arFilterUser); // выбираем пользователей
	while($arUser = $rsUsers->GetNext())
	{
		$arResult["USERS"][] = $arUser;
		
		$users_ids[] = $arUser["ID"];
	}
	
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
		"PROPERTY_" . $arParams["AUTHOR"] => $users_ids,
	);
	$arSortElems = array (
		"NAME" => "ASC"
	);
	
	$cur_user_news = array();
	$arResult["ELEMENTS"] = array();
	$arResult["COUNT"] = 0;
	
	$rsElements = CIBlockElement::GetList($arSortElems, $arFilterElems, false, false, $arSelectElems);
	while($arElement = $rsElements->GetNext())
	{		
		if($arElement["PROPERTY_" . $arParams["AUTHOR"] . "_VALUE"] == $USER->GetID()) {
			$cur_user_news[] = $arElement["ID"];
		}
		
		$arResult["ELEMENTS"][] = $arElement;
	}
	
	foreach($arResult["ELEMENTS"] as $key => $item)
	{		
		if(in_array($item["ID"], $cur_user_news)) {
			unset($arResult["ELEMENTS"][$key]);
		}
	}
	
	foreach($arResult["USERS"] as $key => $user)
	{
		if($user["ID"] == $USER->GetID()) {
			unset($arResult["USERS"][$key]);
		}
	}
	
	$arResult["COUNT"] = count(array_unique(array_column($arResult["ELEMENTS"], "ID")));
	
	$this->includeComponentTemplate();
}

if ($APPLICATION->GetShowIncludeAreas()) {
	$this->AddIncludeAreaIcons(
		Array(
			Array(
				"ID" => "CATALOG_IBLOCK_BUTTON",
				"TITLE" => "ИБ в админке",
				"URL" => "/bitrix/admin/iblock_element_admin.php?IBLOCK_ID=" . $arParams["NEWS_IBLOCK_ID"] . "&type=news&lang=ru",
				"IN_PARAMS_MENU" => true,
			)
		)
	);
}

$APPLICATION->SetTitle("Новостей [" . $arResult["COUNT"] . "]");