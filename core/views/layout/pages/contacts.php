<!doctype html>
<html lang="en">
<head>
	<?=RUI::getMeta();?>
	<link rel="stylesheet" href="http://getbootstrap.com/2.3.2/assets/css/bootstrap.css">
</head>
<body style="background:red;">
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="brand" href="<?=Url::baseUrl();?>">RUI CMS 1.0</a>
				<div class="nav-collapse collapse">
					<?if($user = User::get()):?>
					<p class="navbar-text pull-right" style="margin-left:10px;">
						<a href='<?=Url::baseUrl("user/logout");?>' class="navbar-link">Выход</a>
					</p>
					<p class="navbar-text pull-right" style="margin-left:10px;">
						<a href='<?=Url::baseUrl("user/$user[login]");?>' class="navbar-link">Профиль</a>
					</p>
					<?endif;?>
					<?foreach($topMenu as $item):?>
					<?=$item['path'];?>
					<?endforeach;?>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	<div class="container-fluid">
	  <div class="row-fluid">
	    <div class="span3">
	      <?foreach($leftMenu as $item):?>
	      <?=$item['path'];?>
	      <?endforeach;?>
	    </div><!--/span-->
	    <div class="span9">
	      <div class="row-fluid">
	      	<?=$content;?>
	      </div><!--/row-->
	    </div><!--/span-->
	  </div><!--/row-->
	  <hr>

 	<footer>
 		<p>&copy; RUI CMS 2014</p>
 	</footer>
</div><!--/.fluid-container-->
</body>
</html>