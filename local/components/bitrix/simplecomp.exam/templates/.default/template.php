<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(!empty($arResult)):?>
	<b><?=GetMessage("CATALOG");?></b>
	<ul>
		<?foreach($arResult as $item):?>
			<?
			$sections = array_column($item["ITEMS"], "NAME");
			$sections = implode(", ", $sections);
			?>
		
			<li class="news-name"><b><?=$item["NAME"];?></b> - <?=$item["DATE_ACTIVE_FROM"];?> (<?=$sections;?>)</li>
			<ul>
				<?foreach($item["ITEMS"] as $section):?>
					<?foreach($section["PRODUCTS"] as $product):?>
						<li><?=$product["NAME"];?> - <?=$product["PROPERTY_PRICE_VALUE"];?> - <?=$product["PROPERTY_MATERIAL_VALUE"];?> - <?=$product["PROPERTY_ARTNUMBER_VALUE"];?></li>
					<?endforeach;?>
				<?endforeach;?>
			</ul>
		<?endforeach;?>
	</ul>
<?endif;?>