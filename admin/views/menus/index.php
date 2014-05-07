<h3>Меню</h3>
<div class="span8">
	<?=Url::getFlash('success');?>
	<?if(!empty($menuList)):?>
	<table width="100%" class="table">
		<thead>
			<tr>
				<td>Название</td>
				<td>Код</td>
				<td>Действия</td>
			</tr>
		</thead>
		<tbody>
			<?foreach($menuList as $menu):?>
			<tr>
				<td><?=$menu['title'];?></td>
				<td><?=$menu['code'];?></td>
				<td><a href='<?=Url::baseUrl("admin/menus/edit/$menu[id_menu]")?>'>Редактировать</a> / <a href='<?=Url::baseUrl("admin/menus/delete/$menu[id_menu]")?>' class="delete-btn">Удалить</a></td>
			</tr>
			<?endforeach;?>
		</tbody>
	</table>
	<?else:?>
	<div class="well">
		<span>Меню не найдены</span>
	</div>
	<?endif;?>
</div>