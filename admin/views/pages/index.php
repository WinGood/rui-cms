<?
function printThree($three, $parent = false)
{
	if(!empty($three))
	{
		if(!$parent) echo '<ul class="ul-list sorting">'; else echo '<ul class="sorting">';
		foreach($three as $section)
		{
			$url        = Url::baseUrl("$section[full_url]");
			$editLink   = Url::baseUrl("admin/pages/edit/$section[id_page]");
			$deleteLink = Url::baseUrl("admin/pages/delete/$section[id_page]");

			echo "<li><span><a href=\"$url\" target='_blank'>{$section['title']}</a> <span class='btn-action'><a href=\"$editLink\">Редактировать</a> / <a href=\"$deleteLink\" class='delete-btn'>Удалить</a></span></span>";

			printThree($section['children'], true); 
			echo '</li>';
		}
		if(!$parent) echo '</ul>'; else echo '</ul>';
	}
}
?>
<div class="span8">
	<div class="clearfix">
		<div class="pull-left">
			<h3>Страницы</h3>
		</div>
		<div class="pull-right">
			<ul class="nav nav-pills">
				<li <?=(isset($_GET['view'])) && ($_GET['view'] == 'list') ? null : 'class="active"' ;?>>
					<a href="<?=Url::addGet($_SERVER['REQUEST_URI'], 'view', 'three');?>">Деревом</a>
				</li>
				<li <?=(isset($_GET['view'])) && ($_GET['view'] == 'list') ? 'class="active"' : null ;?>>
					<a href="<?=Url::addGet($_SERVER['REQUEST_URI'], 'view', 'list');?>">Списком</a>
				</li>
			</ul>
		</div>
	</div>
	<?=Url::getFlash('success');?>
	<?if(isset($_GET['view']) && $_GET['view'] == 'list'):?>
	<?if(!empty($three)):?>
	<table class="table">
		<thead>
			<tr>
				<td>Название</td>
				<td>Url</td>
				<td>Действия</td>
			</tr>
		</thead>
		<tbody>
			<?foreach($three as $item):?>
			<tr>
				<td><?=$item['title'];?></td>
				<td><a href="<?=Url::baseUrl("$item[full_url]");?>" target="_blank"><?=$item['full_url'];?></a></td>
				<td><a href='<?=Url::baseUrl("admin/pages/edit/$item[id_page]");?>'>Редактировать</a> / <a href='<?=Url::baseUrl("admin/pages/delete/$item[id_page]");?>' class="delete-btn">Удалить</a></td>
			</tr>
			<?endforeach;?>
		</tbody>
	</table>
	<div class="pagination">
		<?=$pagination;?>
	</div>
	<?else:?>
	<div class="well">
		<span>Страницы не найдены</span>
	</div>
	<?endif;?>
	<?else:?>
		<?if(!empty($three)):?>
			<?printThree($three);?>
		<?else:?>
		<div class="well">
			<span>Страницы не найдены</span>
		</div>
		<?endif;?>
	<?endif;?>
</div>