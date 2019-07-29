<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!empty($arResult["SPECIALDATE"]) && $arParams["SPECIALDATE"] == "Y") {
    $APPLICATION->SetPageProperty("specialdate", $arResult["SPECIALDATE"]);
}