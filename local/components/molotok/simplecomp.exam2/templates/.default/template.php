<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>

<ul>
    <?foreach($arResult["USERS"] as $user):?>
        <li>[<?=$user["ID"];?>] - <?=$user["LOGIN"];?></li>
        <ul>
            <?foreach($arResult["ELEMENTS"] as $item):?>
                <?if($user["ID"] == $item["PROPERTY_" . $arParams["AUTHOR"] . "_VALUE"]):?>
                    <li><?=$item["NAME"];?> - <?=$item["ACTIVE_FROM"];?></li>
                <?endif;?>
            <?endforeach?>
        </ul>
    <?endforeach?>
</ul>
