<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?$APPLICATION->IncludeComponent(
	"molotok:simplecomp.exam2",
	"",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
		"NEWS_IBLOCK_ID" => "1",
		"AUTHOR" => "AUTHOR",
		"AUTHOR_TYPE" => "UF_AUTHOR_TYPE"
	)
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>