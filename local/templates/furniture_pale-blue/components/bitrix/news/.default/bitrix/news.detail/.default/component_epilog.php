<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!empty($arResult["CANONICAL"])) {
    $APPLICATION->SetPageProperty("canonical", $arResult["CANONICAL"]);
}

if ($_REQUEST['complain_submit'] == 'Y') {
    $currentDate = date('d.m.Y H:i:s');
    $user = 'Не авторизован';
    
    if ($USER->IsAuthorized()) {
        $rsUser = CUser::GetByID($USER->GetID());
        $arUser = $rsUser->Fetch();
        
        $user = $arUser['ID'] . ', ' .  $arUser['LOGIN'] . ', ' . $arUser['LAST_NAME'] . $arUser['NAME'] . $arUser['SECOND_NAME'];
    }
    
    //echo "<pre>";print_r($arResult);echo "</pre>";

    $el = new CIBlockElement;

    $props = [];
    $props[10] = $user;
    $props[11] = $arResult['ID'];

    $arLoadProductArray = [
        'IBLOCK_ID' => 6,
        'NAME' => 'Жалоба',
        'ACTIVE' => 'Y',
        'ACTIVE_FROM' => $currentDate,
        'PROPERTY_VALUES' => $props,
    ];
    
    //$productId = $el->Add($arLoadProductArray);
    
    //$arResult['RESULT'] = 'test';
    
    if ($arParams['CUSTOM_AJAX'] == 'Y'): ?>
        <script>
            $('.complainForm').on('submit', function(e) {
                e.preventDefault();
                
                $.ajax({
                    method: 'POST',
                    url: '',
                    success: function(data) {
                        
                    }
                });
                
                console.log('!'); 
            });
        </script>
    <? endif;
}
