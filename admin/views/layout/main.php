<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$title;?> | Админ панель</title>
	<link rel="stylesheet" href="http://getbootstrap.com/2.3.2/assets/css/bootstrap.css" rel="stylesheet">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<?foreach($styles as $style):?>
	<link rel="stylesheet" href='<?=Url::baseUrl("admin/design/css/$style.css");?>'>
	<?endforeach;?>
	<?foreach($scripts as $script):?>
	<script src='<?=Url::baseUrl("admin/scripts/$script.js");?>'></script>
	<?endforeach;?>
	<script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-alert.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
</head>
<body>
	
	<div class="navbar navbar-inverse navbar-fixed-top">
	  <div class="navbar-inner">
	    <div class="container-fluid">
	      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="brand" href="<?=Url::baseUrl();?>">RUI CMS 1.0</a>
	      <div class="nav-collapse collapse">
	        <ul class="nav">	        	
	        	<li <?=Url::isSection('main') ? 'class="active"' : null;?>><a href="<?=Url::baseUrl('admin');?>">Главная</a></li>
	        	<?if(User::canLook('PAGES')):?>
	        	<li <?=Url::isSection('pages') ? 'class="active"' : null;?>><a href="<?=Url::baseUrl('admin/pages');?>">Страницы</a></li>
	        	<?endif;?>
	        	<?if(User::canLook('ALL')):?>
	        	<li <?=Url::isSection('news') ? 'class="active"' : null;?>><a href="<?=Url::baseUrl('admin/news');?>">Новости</a></li>
	        	<li <?=Url::isSection('menus') ? 'class="active"' : null;?>><a href="<?=Url::baseUrl('admin/menus');?>">Меню</a></li>
	        	<li <?=Url::isSection('gallery') ? 'class="active"' : null;?>><a href="<?=Url::baseUrl('admin/gallery');?>">Фотогалерея</a></li>
	        	<li <?=Url::isSection('docs') ? 'class="active"' : null;?>><a href="<?=Url::baseUrl('admin/docs');?>">Документы</a></li>
	        	<li <?=Url::isSection('users') ? 'class="active"' : null;?>><a href="<?=Url::baseUrl('admin/users');?>">Пользователи</a></li>
	        	<li <?=Url::isSection('widgets') ? 'class="active"' : null;?>><a href="<?=Url::baseUrl('admin/widgets');?>">Виджеты</a></li>
	        	<li <?=Url::isSection('settings') ? 'class="active"' : null;?>><a href="<?=Url::baseUrl('admin/settings');?>">Настройки</a></li>
	        	<?endif;?>
	        </ul>
	      </div><!--/.nav-collapse -->
	    </div>
	  </div>
	</div>

	<div class="container">
		<div class="row">
			<div class="span12 content-page">
				<?=$content;?>
				<div class="span3">
					<?if(!empty($rightNav)):?>
					<ul class="nav nav-list">
						<li class="active"><a href="" id="hide-nav">Скрыть навигацию</a></li>
					</ul>
					<br>
					<ul class="nav nav-list nav-box">
						<li class="nav-header">Навигация</li>
					<?foreach($rightNav as $k => $v):?>
						<li <?=(Url::isCurrentPage($k)) ? 'class="active"' : null;?>><a href='<?=Url::baseUrl("{$k}");?>'><?=$v;?></a></li>				
					<?endforeach;?>
					</ul>
					<?endif;?>
				</div>
			</div>
		</div>
	</div> <!-- /container -->
</body>
</html>