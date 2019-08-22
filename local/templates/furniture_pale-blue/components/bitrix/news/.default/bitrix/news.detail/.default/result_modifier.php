<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!empty($arParams["CANONICAL"])) {
    $res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID" => $arParams["CANONICAL"], "PROPERTY_NEWS" => $arResult["ID"]), false, false, Array("ID", "NAME"));
    if($ob = $res->GetNext())
    {
        $arResult["CANONICAL"] = $ob["NAME"];
        $this->__component->SetResultCacheKeys(array("CANONICAL"));
    }
}