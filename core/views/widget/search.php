<div class="well" <?=RUI::frontWidgetBlock($id);?>>
	<form action="<?=Url::baseUrl('search');?>" method="POST" class="nav nav-list" style="padding:0;">
		<p class="nav-header"><?=$title;?></p>
		<input type="text" class="input-medium" name="search">
		<button type="submit" class="btn">Поиск</button>
	</form>
</div>