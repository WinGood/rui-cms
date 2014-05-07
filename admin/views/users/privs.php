<h3>Права пользователей</h3>
<div class="span8">
	<?=Url::getFlash('success');?>
	<table width="100%" class="table">
		<thead>
			<tr>
				<td>Право доступа</td>
				<td class="userGroup">Администратор</td>
				<td class="userGroup">Менеджер</td>
				<td class="userGroup">Пользователь</td>
				<td class="userGroup">Гость</td>
			</tr>
		</thead>
		<form action="">
		<tbody>
			<tr class="moduleName">
				<td colspan="5">Страницы</td>
			</tr>
			<tr class="eventLine">
				<td>Редактирование</td>
				<td class="event"><input type="checkbox"></td>
				<td class="event"><input type="checkbox"></td>
				<td class="event"><input type="checkbox"></td>
				<td class="event"><input type="checkbox"></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="5">
					<br>
					<button type="submit" class="btn btn-primary">Сохранить</button>
				</td>
			</tr>
		</tfoot>
		</form>
	</table>
</div>