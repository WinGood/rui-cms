<h4>Страницы</h4>
<?if(!empty($data)):?>
<ul>
	<?foreach($data as $item):?>
	<li><a href="/<?=$item['full_url'];?>" target="_blank"><?=$item['title']?></a></li>
	<?endforeach;?>
</ul>
<?endif;?>