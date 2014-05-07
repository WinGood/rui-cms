<h3>Добавить шаблон</h3>
<div class="span8">
	<div class="well">
	<?=Url::getFlash('error');?>
	  <form action="<?=$_SERVER['REQUEST_URI'];?>" method="POST" class="form-horizontal">
	    <div class="control-group">
	      <label class="control-label" for="inputTitle">Название</label>
	      <div class="controls">
	        <input type="text" name="name" id="inputTitle" class="input-xlarge" value="<?=isset($fields['name']) ? $fields['name'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputPath">Путь</label>
	      <div class="controls">
	      	<select name="path" id="inputPath">
	      		<?foreach($files as $file):?>
	      		<option value="<?=$file;?>"><?=$file;?></option>
	      		<?endforeach;?>
	      	</select>
	      </div>
	    </div>
	    <div class="control-group">
	      <div class="controls">
	        <button type="submit" class="btn btn-primary">Создать шаблон</button>
	      </div>
	    </div>
	  </form>
	</div>
</div>