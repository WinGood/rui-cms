<h3>Создать группу</h3>
<div class="span8">
	<div class="well">
	<?=Url::getFlash('error');?>
	  <form action="<?=$_SERVER['REQUEST_URI'];?>" method="POST" class="form-horizontal">
	  	<div class="control-group">
	  	  <label class="control-label" for="inputDescription">Название</label>
	  	  <div class="controls">
	  	    <input type="text" name="description" id="inputDescription" class="input-xlarge" value="<?=isset($fields['description']) ? $fields['description'] : null;?>">
	  	  </div>
	  	</div>
	    <div class="control-group">
	      <label class="control-label" for="inputName">Код</label>
	      <div class="controls">
	        <input type="text" name="name" id="inputName" class="input-xlarge" value="<?=isset($fields['name']) ? $fields['name'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <div class="controls">
	        <button type="submit" class="btn btn-primary">Создать группу</button>
	      </div>
	    </div>
	  </form>
	</div>
</div>