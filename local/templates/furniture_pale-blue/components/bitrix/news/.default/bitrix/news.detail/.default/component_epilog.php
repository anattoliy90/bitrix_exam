<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!empty($arResult["CANONICAL"])) {
    $APPLICATION->SetPageProperty("canonical", $arResult["CANONICAL"]);
}

if ($_REQUEST['complain_submit'] == 'Y') {
    $result = '';
    $currentDate = date('d.m.Y H:i:s');
    $user = 'Не авторизован';
    
    if ($USER->IsAuthorized()) {
        $rsUser = CUser::GetByID($USER->GetID());
        $arUser = $rsUser->Fetch();
        
        $user = $arUser['ID'] . ', ' .  $arUser['LOGIN'] . ', ' . $arUser['LAST_NAME'] . $arUser['NAME'] . $arUser['SECOND_NAME'];
    }

    $el = new CIBlockElement;

    $props = [];
    $props[9] = $user;
    $props[10] = $arResult['ID'];

    $arLoadProductArray = [
        'IBLOCK_ID' => NEWS_COMPLAIN_IBLOCK_ID,
        'NAME' => 'Жалоба',
        'ACTIVE' => 'Y',
        'ACTIVE_FROM' => $currentDate,
        'PROPERTY_VALUES' => $props,
    ];
    
    if ($productId = $el->Add($arLoadProductArray)) {
        $result = GetMessage('SUCCESS') . $productId;
    } else {
        $result = GetMessage('ERROR');
    }
    ?>
    
    <script>
        <? if ($arParams['CUSTOM_AJAX'] == 'Y'): ?>
            $('.complainForm').on('submit', function(e) {
                e.preventDefault();
                
                var formResult = $('.complainForm__result');
                
                $.ajax({
                    method: 'POST',
                    url: './',
                    success: function(res) {
                        formResult.html('<?= $result; ?>');
                    }
                }); 
            });
        <? else: ?>
            
        <? endif; ?>
    </script>
<? }
