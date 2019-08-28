<?
IncludeModuleLangFile(__FILE__);

AddEventHandler("main", "OnBeforeEventAdd", array("MyClass", "OnBeforeEventAddHandler"));
AddEventHandler("main", "OnBuildGlobalMenu", "MyOnBuildGlobalMenu");

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
}

function MyOnBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu)
{
	global $USER;
	$arGroups = CUser::GetUserGroup($USER->GetID());
	
	if(in_array(5, $arGroups)) {
		unset($aGlobalMenu["global_menu_desktop"]);
		
		foreach($aModuleMenu as $key => $menu) {
			if($menu["parent_menu"] == "global_menu_content" && $menu["items_id"] == "menu_iblock") {
				unset($aModuleMenu[$key]);
			}
		}
	}
}