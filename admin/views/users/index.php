<h3>Пользователи</h3>
<div class="span8">
	<?=Url::getFlash('success');?>
	<?if(!empty($users)):?>
	<table width="100%" class="table">
		<thead>
			<tr>
				<td>Логин</td>
				<td>Группа</td>
				<td>Действия</td>
			</tr>
		</thead>
		<tbody>
			<?foreach($users as $user):?>
			<tr>
				<td><?=$user['login'];?></td>
				<td><?=$user['description'];?></td>
				<td><a href='<?=Url::baseUrl("admin/users/edit/$user[id]")?>'>Редактировать</a> / <a href='<?=Url::baseUrl("admin/users/delete/$user[id]")?>' class="delete-btn">Удалить</a></td>
			</tr>
			<?endforeach;?>
		</tbody>
	</table>
	<div class="pagination">
		<?=$pagination;?>
	</div>
	<?else:?>
	<div class="well">
		<span>Пользователи не найдены</span>
	</div>
	<?endif;?>
</div>
