<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(!empty($arResult["ITEMS"])):?>
	<div>
		<?=GetMessage("FILTER");?> <a href="<?=$APPLICATION->GetCurPage(false) . "?F=Y";?>" target="_blank"><?=$APPLICATION->GetCurPage(false) . "?F=Y";?></a>
	</div>
	<ul>
		<?foreach($arResult["ITEMS"] as $firm => $items):?>
			<li><b><?=$firm;?></b></li>
			<ul>
				<?foreach($items as $item):?>
					<?
					$this->AddEditAction($item["ID"], $item["EDIT_LINK"], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($item["ID"], $item["DELETE_LINK"], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));
					?>
					
					<li id="<?=$this->GetEditAreaId($item["ID"]);?>">
						<?=$item["NAME"];?> - <?=$item["PROPERTY_PRICE_VALUE"];?> - <?=$item["PROPERTY_MATERIAL_VALUE"];?> - <?=$item["PROPERTY_ARTNUMBER_VALUE"];?> (<?=$item["DETAIL_PAGE_URL"];?>)
					</li>
				<?endforeach;?>
			</ul>
		<?endforeach;?>
	</ul>
<?endif;?>