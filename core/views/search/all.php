<h3>Поиск</h3>
<?=Url::getFlash('error');?>
<div class="well clearfix">
	<h3>Результаты поиска</h3>
	<?if(!empty($result)):?>
		<?foreach($result as $item):?>
			<?=$item;?>
		<?endforeach;?>
	<?else:?>
		<p>Ничего не найдено</p>
	<?endif;?>
</div>