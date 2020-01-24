<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->IncludeComponent(
	"molotok:simplecomp.exam3", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"CATALOG_IBLOCK" => "2",
		"CLASSIFIER_IBLOCK" => "5",
		"DETAIL_URL_TEMPLATE" => "catalog_exam/#SECTION_ID#/#ELEMENT_CODE#",
		"PROP_CODE" => "FIRM",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"ITEMS_ON_PAGE" => "2",
	),
	false
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
