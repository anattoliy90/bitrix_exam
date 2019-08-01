<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"CATALOG_IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CATALOG_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"NEWS_IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("NEWS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"USER_PROPERTY" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("USER_PROPERTY"),
			"TYPE" => "STRING",
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
	),
);
?>
