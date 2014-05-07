<div class="well sidebar-nav" <?=RUI::frontWidgetBlock($id);?>>
	<ul class="nav nav-list">
		<li class="nav-header"><?=$title;?></li>
		<?foreach($pages as $item):?>
		<?$url = $item['full_url'];?>
		<li><a href='<?=Url::baseUrl($url);?>'><?=$item['title_in_menu'];?></a></li>
		<?endforeach;?> 
	</ul>
</div><!--/.well -->