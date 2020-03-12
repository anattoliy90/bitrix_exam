<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/ex2/complexcomponent/#",
		"RULE" => "",
		"ID" => "molotok:complexcomp.exam-materials",
		"PATH" => "/ex2/complexcomponent/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/max/images/#",
		"RULE" => "",
		"ID" => "bitrix:photo",
		"PATH" => "/local/components/molotok/complexcomp.exam-materials/help/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/products/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/products/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/services/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/services/index.php",
		"SORT" => "100",
	),
	array(
		"CONDITION" => "#^/news/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/news/index.php",
	),
);

?>