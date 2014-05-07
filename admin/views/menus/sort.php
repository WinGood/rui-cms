<h3>Сортировка элементов меню "<?=$fields['title'];?>"</h3>
<div class="span8">
	<div class="well">
	<?=Url::getFlash('error');?>
	  <form action="<?=$_SERVER['REQUEST_URI'];?>" method="POST" class="form-horizontal form-sorting">
	    <div class="control-group">
	      <label class="control-label" for="inputEl">Элементы</label>
	      <div class="controls">
		      <ul class="sorting">
		      	<?foreach($menu as $item):?>
		      	<li data-id-page="<?=$item['id_page'];?>"><?=$item['title'];?></li>
		      	<?endforeach;?>
		      </ul>
	      </div>
	    </div>
	    <div class="control-group">
	      <div class="controls">
	      	<input type="hidden" name="pages" value="">
	        <button type="submit" class="btn btn-primary">Обновить меню</button>
	      </div>
	    </div>
	  </form>
	</div>
</div>