<?
function printThree($three, $pages = array(), $shift = 0)
{
	if(!empty($three))
	{
		foreach($three as $section)
		{
			?><option <?=($shift) ? 'disabled' : null?> value="<?=$section['id_page']?>"
			<? if(in_array($section['id_page'], $pages))
				echo 'selected'; ?>
			>
			<? for($i = 0; $i < $shift; $i++)echo '-';?>
			<?=$section['title_in_menu']?></option><?
			printThree($section['children'], $pages, $shift + 1); 
		}
	}
}
?>
<h3>Редактирование виджета "<?=$fields['name']?>"</h3>
<div class="span8">
	<div class="well">
	<?=Url::getFlash('error');?>
	  <form action="<?=$_SERVER['REQUEST_URI'];?>" method="POST" class="form-horizontal">
	    <div class="control-group">
	      <label class="control-label" for="inputName">Название</label>
	      <div class="controls">
	        <input type="text" name="name" id="inputName" class="input-xlarge" value="<?=isset($fields['name']) ? $fields['name'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputNameInMenu">Название в меню</label>
	      <div class="controls">
	        <input type="text" name="name_in_menu" id="inputNameInMenu" class="input-xlarge" value="<?=isset($fields['name_in_menu']) ? $fields['name_in_menu'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputDesc">Описание</label>
	      <div class="controls">
	      	<textarea name="description" id="inputDesc" class="input-xlarge" rows="4"><?=isset($fields['description']) ? $fields['description'] : null;?></textarea>
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputPath">Путь</label>
	      <div class="controls">
	      	<input type="text" name="path" id="inputPath" class="input-xlarge" value="<?=isset($fields['path']) ? $fields['path'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputEl">Страницы</label>
	      <select id="inputEl" name="pages[]" multiple class="input-medium" style="height:180px;width:200px;">
	      	<?printThree($three, $fields['pages']);?>
	      </select>
	    </div>
	    <div class="control-group">
	      <div class="controls">
	        <button type="submit" class="btn btn-primary">Обновить виджет</button>
	      </div>
	    </div>
	  </form>
	</div>
</div>