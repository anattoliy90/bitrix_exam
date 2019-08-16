<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?$APPLICATION->IncludeComponent(
	"molotok:simplecomp.exam",
	"",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"CATALOG_IBLOCK_ID" => "2",
		"NEWS_IBLOCK_ID" => "1",
		"USER_PROPERTY" => "UF_NEWS_LINK",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000"
	)
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>