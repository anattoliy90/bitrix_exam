<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?$APPLICATION->IncludeComponent(
	"bitrix:simplecomp.exam",
	"",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "products",
		"IBLOCKS" => array("2"),
		"DETAIL_URL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "180",
		"CACHE_GROUPS" => "Y",
		"PARENT_SECTION" => ""
	)
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>