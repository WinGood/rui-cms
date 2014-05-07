<h3>Создать пользователя</h3>
<div class="span8">
	<div class="well">
	<?=Url::getFlash('error');?>
	  <form action="<?=$_SERVER['REQUEST_URI'];?>" method="POST" class="form-horizontal">
	    <div class="control-group">
	      <label class="control-label" for="inputLogin">Логин</label>
	      <div class="controls">
	        <input type="text" name="login" id="inputLogin" class="input-xlarge" value="<?=isset($fields['login']) ? $fields['login'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputPassword">Пароль</label>
	      <div class="controls">
	        <input type="password" name="password" id="inputPassword" class="input-xlarge">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputName">Имя</label>
	      <div class="controls">
	        <input type="text" name="name" id="inputName" class="input-xlarge" value="<?=isset($fields['name']) ? $fields['name'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputRole">Группа</label>
	      <div class="controls">
	        <select id="inputRole" name="id_role" class="input-medium">
	        	<?foreach($roles as $item):?>
	        	<option value="<?=$item['id_role']?>"><?=$item['description'];?></option>
	        	<?endforeach;?>
	        </select>
	      </div>
	    </div>
	    <div class="control-group">
	      <div class="controls">
	        <button type="submit" class="btn btn-primary">Создать пользователя</button>
	      </div>
	    </div>
	  </form>
	</div>
</div>