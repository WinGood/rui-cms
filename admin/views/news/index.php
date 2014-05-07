<div class="span8">
	<table class="table">
		<thead>
			<tr>
				<td>Название</td>
				<td>Категория</td>
				<td>Действия</td>
			</tr>
		</thead>
		<tbody>
			<?foreach($news as $item):?>
			<tr>
				<td><?=$item['title'];?></td>
				<td><a href="<?=Url::baseUrl("news/$item[url]");?>" target="_blank"><?=$item['url'];?></a></td>
				<td><a href='<?=Url::baseUrl("admin/news/edit/$item[id_news]");?>'>Редактировать</a> / <a href='<?=Url::baseUrl("admin/news/delete/$item[id_news]");?>' class="delete-btn">Удалить</a></td>
			</tr>
			<?endforeach;?>
		</tbody>
	</table>
</div>