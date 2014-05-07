<h3>Фотогалереи</h3>
<div class="span8">
	<?=Url::getFlash('success');?>
	<?if(!empty($gallery)):?>
	<table width="100%" class="table">
		<thead>
			<tr>
				<td>Название</td>
				<td>Код</td>
				<td>Действия</td>
			</tr>
		</thead>
		<tbody>
	<?foreach($gallery as $item):?>
		<tr>
			<td><?=$item['title'];?></td>
			<td><?=$item['code'];?></td>
			<td><a href='<?=Url::baseUrl("admin/gallery/images/$item[id_gallery]");?>'>Просмотр</a> / <a href='<?=Url::baseUrl("admin/gallery/upload/$item[id_gallery]");?>'>Загрузить</a> / <a href=<?=Url::baseUrl("admin/gallery/edit/$item[id_gallery]");?>>Редактирование</a> / <a href='<?=Url::baseUrl("admin/gallery/delete/$item[id_gallery]");?>' class="delete-btn">Удалить</a></td>
		</tr>
	<?endforeach;?>
		</tbody>
	</table>
	<?else:?>
	<div class="well">
		<span>Галереи не найдены</span>
	</div>
	<?endif;?>
</div>