<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(!empty($arResult["ITEMS"])):?>
	<ul>
		<?foreach($arResult["ITEMS"] as $firm => $items):?>
			<li><b><?=$firm;?></b></li>
			<ul>
				<?foreach($items as $item):?>
					<li>
						<a href="#"><?=$item["NAME"];?> - <?=$item["PROPERTY_PRICE_VALUE"];?> - <?=$item["PROPERTY_MATERIAL_VALUE"];?> - <?=$item["PROPERTY_ARTNUMBER_VALUE"];?></a>
					</li>
				<?endforeach;?>
			</ul>
		<?endforeach;?>
	</ul>
<?endif;?>