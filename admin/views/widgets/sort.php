<?
function printThree($three, $parent = false)
{
	if(!empty($three))
	{
		if(!$parent) echo '<ol class="dd-list">'; else echo '<ol class="dd-list">';
		foreach($three as $k => $v)
		{
			echo "
			<li class='dd-item' data-id='$k]'>
			<div class='dd-handle'>
				{$v['title_in_menu']}
			</div>";

			printThree($v['children'], true); 
			echo '</li>';
		}
		if(!$parent) echo '</ol>'; else echo '</ol>';
	}
}
?>
<h3>Сортировка элементов виджета "<?=$fields['name'];?>"</h3>
<div class="span8">
	<div class="well">
	<?=Url::getFlash('error');?>
	  <form action="<?=$_SERVER['REQUEST_URI'];?>" method="POST" class="form-horizontal">
	  	<div id="sort-box" class="dd">
	  		<?printThree($pages);?>
	  	</div>
	  	<input type="hidden" name="id_widget" value="<?=$fields['id_widget'];?>">
	  </form>
	</div>
</div>