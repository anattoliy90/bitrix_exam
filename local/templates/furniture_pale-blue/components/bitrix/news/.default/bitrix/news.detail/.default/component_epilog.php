<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!empty($arResult["CANONICAL"])) {
    $APPLICATION->SetPageProperty("canonical", $arResult["CANONICAL"]);
}

function makeComplain($id) {
    global $USER;
    $currentDate = date('d.m.Y H:i:s');
    $user = 'Не авторизован';
    $result = '';
    
    if ($USER->IsAuthorized()) {
        $rsUser = CUser::GetByID($USER->GetID());
        $arUser = $rsUser->Fetch();
        
        $user = $arUser['ID'] . ', ' .  $arUser['LOGIN'] . ', ' . $arUser['LAST_NAME'] . ' ' . $arUser['NAME'] . ' ' . $arUser['SECOND_NAME'];
    }

    $el = new CIBlockElement;

    $props = [];
    $props['USER'] = $user;
    $props['NEWS'] = $id;

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
    
    return $result;
}

if ($_REQUEST['complain_submit'] == 'Y') {
    if ($arParams['CUSTOM_AJAX'] == 'Y') {
        $APPLICATION->RestartBuffer();
        echo makeComplain($arResult['ID']);
        die();
    } else { ?>
        <script>
            $('.complainForm__result').html('<?= makeComplain($arResult['ID']); ?>');
        </script>
    <? }
}
?>
    
<script>
    <? if ($arParams['CUSTOM_AJAX'] == 'Y'): ?>
        $('.complainForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                method: 'POST',
                url: '<?= POST_FORM_ACTION_URI; ?>',
                data: 'complain_submit=Y',
                success: function(res) {
                    $('.complainForm__result').html(res);
                }
            });
        });
    <? endif; ?>
</script>
