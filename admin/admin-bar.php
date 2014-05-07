<style type="text/css">
body {
	padding-top: 40px;
	padding-bottom: 40px;
}
.sidebar-nav {
	padding: 9px 0;
}
.form-modal.form-horizontal .control-label{
	width: 140px;
	text-align: left;
}
.form-modal.form-horizontal .controls{
	margin-left: 140px;
}
.form-modal.form-horizontal .controls input[type="text"], .form-modal.form-horizontal .controls textarea{
	width: 100%;
	height: 30px;
}
#admin-bar-hide .modal{
	width: 700px;
	margin-left: -340px;
}
#admin-bar-hide .modal .modal-body{
	max-height: 560px;
}
.front-edit-btn{
	background: url(http://png-5.findicons.com/files/icons/2232/wireframe_mono/16/pencil.png) no-repeat;
	width: 16px;
	height: 16px;
	display: block;
	position: absolute;
	right: 5px;
	top: 8px;
}
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-dropdown.js"></script>
<script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-modal.js"></script>
<link rel="stylesheet" href="http://getbootstrap.com/2.3.2/assets/css/bootstrap.css">
<script src="/admin/scripts/admin-bar.js"></script>
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="brand" href="<?=Url::baseUrl('admin');?>">Admin panel</a>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<li><a href="<?=Url::baseUrl('admin');?>">Админ панель</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Страницы <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#addPageModal" role="button" data-toggle="modal">Добавить</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Меню <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#addPageModal" role="button" data-toggle="modal">Сортировать</a></li>
						</ul>
					</li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</div>
<div id="admin-bar-hide">
	<div id="addPageModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3>Добавление страницы</h3>
	  </div>
	  <div class="modal-body">
	  	<form action="<?=Url::baseUrl('admin/pages/add');?>" method="POST" class="form-modal form-horizontal">
	  		<div class="control-group">
	  		  <label class="control-label" for="inputTitle">Название</label>
	  		  <div class="controls">
	  		    <input type="text" name="title" id="inputTitle" value="<?=isset($fields['title']) ? $fields['title'] : null;?>">
	  		  </div>
	  		</div>
	  		<div class="control-group">
	  		  <label class="control-label" for="inputInMenuTitle">Название в меню</label>
	  		  <div class="controls">
	  		    <input type="text" name="title_in_menu" id="inputInMenuTitle" class="input-xlarge" value="<?=isset($fields['title_in_menu']) ? $fields['title_in_menu'] : null;?>">
	  		  </div>
	  		</div>
	  		<div class="control-group">
	  		  <label class="control-label" for="inputUrl">Адрес</label>
	  		  <div class="controls">
	  		    <input type="text" name="url" id="inputUrl" class="input-xlarge" value="<?=isset($fields['url']) ? $fields['url'] : null;?>">
	  		  </div>
	  		</div>
	  		<div class="control-group">
	  		  <label class="control-label" for="replace">Текст</label>
	  		  <div class="controls">
	  		    <textarea id="replace" name="content" rows="6" class="input-xlarge"><?=isset($fields['content']) ? $fields['content'] : null;?></textarea>
	  		  </div>
	  		</div>
	  		<div class="control-group">
	  		  <label class="control-label" for="inputSeoTitle" class="input-xlarge">SEO заголовок</label>
	  		  <div class="controls">
	  		    <input type="text" name="metaTitle" id="inputSeoTitle" class="input-xlarge" value="<?=isset($fields['metaTitle']) ? $fields['metaTitle'] : null;?>">
	  		  </div>
	  		</div>
	  		<div class="control-group">
	  		  <label class="control-label" for="inputSeoKey" class="input-xlarge">SEO ключ.слова</label>
	  		  <div class="controls">
	  		    <input type="text" name="metaKeywords" id="inputSeoKey" class="input-xlarge" value="<?=isset($fields['metaKeywords']) ? $fields['metaKeywords'] : null;?>">
	  		  </div>
	  		</div>
	  		<div class="control-group">
	  		  <label class="control-label" for="inputSeoDesc" class="input-xlarge">SEO описание</label>
	  		  <div class="controls">
	  		    <input type="text" name="metaDescription" id="inputSeoDesc" class="input-xlarge" value="<?=isset($fields['metaDescription']) ? $fields['metaDescription'] : null;?>">
	  		  </div>
	  		</div>
	  		<div class="control-group">
	  		  <label class="control-label" for="inputIsShow" class="input-xlarge">Показывать?</label>
	  		  <div class="controls">
	  		    <input type="checkbox" name="is_show" id="inputIsShow" class="input-xlarge" <?=isset($fields['is_show']) ? 'checked' : null;?> value="1">
	  		  </div>
	  		</div>
	  	</form>
	  </div>
	  <div class="modal-footer">
	    <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
	    <button class="btn btn-primary">Добавить страницу</button>
	  </div>
	</div>
</div>