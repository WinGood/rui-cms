<h3>Редактирование галереи - "<?=$fields['title'];?>"</h3>
<div class="span8">
	<div class="well">
	<?=Url::getFlash('error');?>
	  <form action="<?=$_SERVER['REQUEST_URI'];?>" method="POST" class="form-horizontal">
	    <div class="control-group">
	      <label class="control-label" for="inputTitle">Название</label>
	      <div class="controls">
	        <input type="text" name="title" id="inputTitle" class="input-xlarge" value="<?=isset($fields['title']) ? $fields['title'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputCode">Код</label>
	      <div class="controls">
	        <input type="text" name="code" id="inputCode" class="input-xlarge" value="<?=isset($fields['code']) ? $fields['code'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <div class="controls">
	        <button type="submit" class="btn btn-primary">Обновить галерею</button>
	      </div>
	    </div>
	  </form>
	</div>
</div>