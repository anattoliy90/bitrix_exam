<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->IncludeComponent(
	"molotok:simplecomp.exam3",
	"",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"CATALOG_IBLOCK" => "2",
		"CLASSIFIER_IBLOCK" => "5",
		"DETAIL_URL_TEMPLATE" => "/products/#SECTION_ID#/#ELEMENT_CODE#/",
		"PROP_CODE" => "FIRM",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	)
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
