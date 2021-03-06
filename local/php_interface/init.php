<?
IncludeModuleLangFile(__FILE__);

define("SERVICES_IBLOCK_ID", 3);
define("FIRM_IBLOCK_ID", 5);
define("NEWS_COMPLAIN_IBLOCK_ID", 5);

AddEventHandler("main", "OnBeforeEventAdd", array("MyClass", "OnBeforeEventAddHandler"));
AddEventHandler("main", "OnBuildGlobalMenu", "MyOnBuildGlobalMenu");
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("MyClass", "OnBeforeIBlockElementUpdateHandler"));
AddEventHandler("main", "OnEpilog", "controller_404");

function controller_404() {
	if(defined("ERROR_404") && ERROR_404 == "Y") {
		CEventLog::Add(array(
			"SEVERITY" => "INFO",
			"AUDIT_TYPE_ID" => "ERROR_404",
			"MODULE_ID" => "main",
			"DESCRIPTION" => $_SERVER["REQUEST_URI"],
		));
	}
	
	/*$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 5, "=NAME" => $_SERVER["REQUEST_URI"]), false, false, array("ID", "NAME", "PROPERTY_TITLE", "PROPERTY_DESCRIPTION"));
	while($ob = $res->GetNext()) {
		global $APPLICATION;
		$APPLICATION->SetTitle($ob["PROPERTY_TITLE_VALUE"]);
		$APPLICATION->SetPageProperty($ob["PROPERTY_DESCRIPTION_VALUE"]);
	}*/
}

class MyClass
{
	function OnBeforeEventAddHandler(&$event, &$lid, &$arFields)
	{
        if($event == "FEEDBACK_FORM") {
            global $USER;
           
            if(!$USER->IsAuthorized()) {
                $arFields["AUTHOR"] = GetMessage("USER_NOT_AUTHORIZED") . $arFields["AUTHOR"];
            } else {
                $arFields["AUTHOR"] = GetMessage("USER_AUTHORIZED") . $USER->GetID() . " (" . $USER->GetLogin() . ") " . $USER->GetFullName() . GetMessage("FORM_DATA") . $arFields["AUTHOR"];
            }
           
            CEventLog::Add(array(
                "SEVERITY" => "SECURITY",
                "AUDIT_TYPE_ID" => GetMessage("REPLACE_DATA"),
                "MODULE_ID" => "main",
                "ITEM_ID" => $USER->GetID(),
                "DESCRIPTION" => GetMessage("REPLACE_DATA") . " – " . $arFields["AUTHOR"],
            ));
        }
	}
	
    function OnBeforeIBlockElementUpdateHandler(&$arFields)
    {
		$res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $arFields["IBLOCK_ID"], "ID" => $arFields["ID"]), false, false, array("ID", "SHOW_COUNTER"));
		if($ob = $res->GetNext()) {
			if($arFields["ACTIVE"] == "N" && $ob["SHOW_COUNTER"] > 2) {
				global $APPLICATION;
				$APPLICATION->throwException(GetMessage("NOT_AVAIL_ELEMENT") . $ob["SHOW_COUNTER"] . GetMessage("ELEMENT_VIEWS"));
				return false;
			}
		}
    }
}

function MyOnBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu) {
	global $USER;
	$arGroups = CUser::GetUserGroup($USER->GetID());
	
	if(in_array(5, $arGroups) && !$USER->IsAdmin()) {
		unset($aGlobalMenu["global_menu_desktop"]);
		
		foreach($aModuleMenu as $key => $menu) {
			if($menu["parent_menu"] == "global_menu_content" && $menu["items_id"] == "menu_iblock") {
				unset($aModuleMenu[$key]);
			}
		}
	}
}

function CheckUserCount() {
	$usersId = [];
	$adminUsersEmail = [];
	$usersLastDate = COption::GetOptionString("main", "users_last_date");
	
	$today = new DateTime("now");
	$today->format('d.m.Y H:i:s');
	$usersLastDateTime = new DateTime($usersLastDate);
	$days = $today->diff($usersLastDateTime)->d;
	
	$rsUsers = CUser::GetList(($by="ID"), ($order="ASC"), ["DATE_REGISTER_1" => $usersLastDate]);
	while($arUsers = $rsUsers->Fetch()) {
		$usersId[] = $arUsers["ID"];
	}
	
	$rsUser = CUser::GetList(($by = "NAME"), ($order = "desc"), ["GROUPS_ID" => "1"]);
	while ($arUser = $rsUser->Fetch()) {
		$adminUsersEmail[] = $arUser["EMAIL"];
	}
	
	if (!empty($adminUsersEmail)) {
		foreach ($adminUsersEmail as $email) {
			$arEventFields = [
				"EMAIL" => $email,
				"COUNT" => count($usersId),
				"DAYS" => $days,
			];
			
			CEvent::Send("USERS_COUNT", SITE_ID, $arEventFields);
		}
	}

	COption::SetOptionString("main", "users_last_date", date("d.m.Y H:i:s", time()));
	
	return "CheckUserCount();";
}
