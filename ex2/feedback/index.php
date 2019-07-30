<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?$APPLICATION->IncludeComponent(
	"bitrix:main.feedback",
	"",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"USE_CAPTCHA" => "Y",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"EMAIL_TO" => "test@gmail.com",
		"REQUIRED_FIELDS" => array(),
		"EVENT_MESSAGE_ID" => array("7")
	)
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>