<?if(!empty($img)):?>
	<?foreach($img as $item):?>
	<img src="<? echo '/' . GALLERY_DIR_SMALL . $item['path'];?>">
	<?endforeach;?>
<?endif;?>