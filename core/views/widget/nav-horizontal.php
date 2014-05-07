<ul class="nav">
	<?foreach($pages as $item):?>
	<?$url = $item['full_url'];?>
		<li <?=Url::isActive($item['full_url']) ? 'class="active"' : null;?>><a href='<?=Url::baseUrl($url);?>'><?=$item['title_in_menu'];?></a></li>
	<?endforeach;?>
</ul>