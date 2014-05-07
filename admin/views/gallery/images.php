<h3><?=$gallery['title']?></h3>
<div class="span8">
	<div id="usersettings">
		<div>
			<input type="button" id="btn_save" value="Save sorting" class="btn btn-danger">
			<span id="msg_save">Saved!</span>
		</div>
		<? if(count($images) > 0):?>
			<ul id="gallery_sortable" class="noicons noshifts">
			<? foreach($images as $img):?>
				<li class="delimg" id_image="<?=$img['id_image']?>">
					<form method="post">
						<input type="submit" class="delete" value="">
						<input type="hidden" name="id_gallery" value="<?=$img['id_gallery']?>">
						<input type="hidden" name="id_image" class="delete" value="<?=$img['id_image']?>">
					</form>
					<a href="gallery/names/<?=$img['id_image']?>">Edit image</a>
					<img src='<?=Url::baseUrl(). '/'. GALLERY_DIR_SMALL . $img['path'];?>' class="im">		
				</li>
			<? endforeach ?>
			</ul>
		<? else: ?>
			<p>There are no images</p>
		<? endif; ?>
	</div>
	<div class="clear"></div>
</div>