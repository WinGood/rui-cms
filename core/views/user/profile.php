<?if(!empty($user)):?>
<h3>Профиль пользователя "<?=$user['login'];?>"</h3>
<div class="well clearfix">
	<?if($current):?>
	<p>Это вы</p>
	<ul>
		<li><a href="<?=Url::baseUrl('user/logout');?>">Выход</a></li>
	</ul>
	<?else:?>
	<p>Это не ваш профиль</p>
	<?endif;?>
</div>
<?else:?>
<div class="well">
	<span>Пользователь не найден</span>
</div>
<?endif;?>