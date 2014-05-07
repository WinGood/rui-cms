<h3>Авторизация пользователя</h3>
<div class="well clearfix">
	<?=Url::getFlash('success');?>
	<?=Url::getFlash('error');?>
	<form action="<?=$_SERVER['REQUEST_URI'];?>" class="form-horizontal" method="POST">
	  <div class="control-group">
	    <label class="control-label" for="inputLogin">Логин</label>
	    <div class="controls">
	      <input type="text" id="inputLogin" name="login" placeholder="Логин" value="<?=isset($fields['login']) ? $fields['login'] : null;?>">
	    </div>
	  </div>
	  <div class="control-group">
	    <label class="control-label" for="inputPassword">Пароль</label>
	    <div class="controls">
	      <input type="password" id="inputPassword" name="password" placeholder="Пароль">
	    </div>
	  </div>
	  <div class="control-group">
	    <div class="controls">
	      <label class="checkbox">
	        <input type="checkbox"> Запомнить меня
	      </label>
	      <button type="submit" class="btn btn-primary">Вход</button>
	    </div>
	  </div>
	</form>
</div>