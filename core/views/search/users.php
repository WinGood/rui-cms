<h4>Пользователи</h4>
<?if(!empty($data)):?>
<ul>
	<?foreach($data as $item):?>
	<li><a href="/user/<?=$item['login'];?>" target="_blank"><?=$item['login']?></a></li>
	<?endforeach;?>
</ul>
<?endif;?>