<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		"CATALOG_IBLOCK" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CATALOG_IBLOCK"),
			"TYPE" => "STRING",
			"VALUES" => "",
		),
		"CLASSIFIER_IBLOCK" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CLASSIFIER_IBLOCK"),
			"TYPE" => "STRING",
			"VALUES" => "",
		),
		"DETAIL_URL_TEMPLATE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("DETAIL_URL_TEMPLATE"),
			"TYPE" => "STRING",
			"VALUES" => "",
		),
		"PROP_CODE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("PROP_CODE"),
			"TYPE" => "STRING",
			"VALUES" => "",
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>3600),
	),
);
