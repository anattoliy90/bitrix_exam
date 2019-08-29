<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("NEWS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
        "AUTHOR" => array(
			"NAME" => GetMessage("AUTHOR"),
			"TYPE" => "STRING",
		),
        "AUTHOR_TYPE" => array(
			"NAME" => GetMessage("AUTHOR_TYPE"),
			"TYPE" => "STRING",
		),
        "CACHE_TIME"  =>  Array("DEFAULT"=>3600000),
	),
);