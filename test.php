<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");?>

<?$APPLICATION->IncludeComponent(
	"bitrix:main.site.selector",
	"dropdown",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"SITE_LIST" => array("*all*"),
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	)
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>