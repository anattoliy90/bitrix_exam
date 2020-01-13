<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->IncludeComponent(
	"molotok:simplecomp.exam3",
	"",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"CATALOG_IBLOCK" => "1",
		"CLASSIFIER_IBLOCK" => "2",
		"DETAIL_URL_TEMPLATE" => "url",
		"PROP_CODE" => "code",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	)
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
