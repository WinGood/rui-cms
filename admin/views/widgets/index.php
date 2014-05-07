<h3>Виджеты</h3>
<div class="span8">
	<?=Url::getFlash('success');?>
	<?if(!empty($widgets)):?>
	<table width="100%" class="table">
		<thead>
			<tr>
				<td>Название</td>
				<td>Описание</td>
				<td>Действия</td>
			</tr>
		</thead>
		<tbody>
			<?foreach($widgets as $widget):?>
			<tr>
				<td><?=$widget['name'];?></td>
				<td><?=$widget['description'];?></td>
				<td>
					<a href="/admin/widgets/edit/<?=$widget['id_widget'];?>">Редактировать</a> /
					<?if($widget['is_sort']):?><a href="/admin/widgets/sort/<?=$widget['id_widget'];?>">Сортировать</a> / <?endif;?> 
					<a href="/admin/widgets/delete/<?=$widget['id_widget'];?>" class="delete-btn">Удалить</a>
				</td>
			</tr>
			<?endforeach;?>
		</tbody>
	</table>
	<?else:?>
	<div class="well">
		<span>Виджеты не найдены</span>
	</div>
	<?endif;?>
</div>
